<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentFlag;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentFlagController extends Controller
{
    /**
     * Display a listing of content flags
     */
    public function index(Request $request)
    {
        $query = ContentFlag::with(['user', 'flaggable', 'reviewer'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by reason
        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        // Filter by content type
        if ($request->filled('type')) {
            $query->where('flaggable_type', $request->type);
        }

        $flags = $query->paginate(20);

        $stats = [
            'total' => ContentFlag::count(),
            'pending' => ContentFlag::where('status', 'pending')->count(),
            'reviewed' => ContentFlag::where('status', 'reviewed')->count(),
            'action_taken' => ContentFlag::where('status', 'action_taken')->count(),
            'dismissed' => ContentFlag::where('status', 'dismissed')->count(),
        ];

        return view('admin.content-flags.index', compact('flags', 'stats'));
    }

    /**
     * Show the specified flag
     */
    public function show(ContentFlag $flag)
    {
        $flag->load(['user', 'flaggable', 'reviewer']);
        
        return view('admin.content-flags.show', compact('flag'));
    }

    /**
     * Update the flag status
     */
    public function update(Request $request, ContentFlag $flag)
    {
        $request->validate([
            'status' => 'required|in:reviewed,dismissed,action_taken',
            'admin_notes' => 'nullable|string|max:1000',
            'action' => 'nullable|in:delete_content,hide_content,warn_user,ban_user',
        ]);

        $flag->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // Take action on the content if specified
        if ($request->filled('action') && $request->status === 'action_taken') {
            $this->takeAction($flag, $request->action);
        }

        return redirect()->route('admin.content-flags.index')
            ->with('success', 'Flag has been updated successfully.');
    }

    /**
     * Take action on flagged content
     */
    private function takeAction(ContentFlag $flag, string $action)
    {
        $content = $flag->flaggable;
        
        if (!$content) {
            return;
        }

        $user = $content->user;

        switch ($action) {
            case 'delete_content':
                // Delete the content permanently
                $content->delete();
                break;
                
            case 'hide_content':
                // Mark content as hidden (hidden from public view)
                $content->update(['is_hidden' => true]);
                break;
                
            case 'warn_user':
                // Mark the content as reported
                $content->update(['is_reported' => true]);
                
                if ($user) {
                    // Create warning record
                    $warning = \App\Models\UserWarning::create([
                        'user_id' => $user->id,
                        'issued_by' => Auth::id(),
                        'content_flag_id' => $flag->id,
                        'reason' => $flag->reason_label,
                        'message' => "Your content has been flagged for: {$flag->reason_label}. " . 
                                   ($flag->admin_notes ? "Admin notes: {$flag->admin_notes}" : "Please review our community guidelines."),
                    ]);

                    // Increment warning count
                    $user->increment('warning_count');
                    $user->update(['last_warned_at' => now()]);

                    // Send notification
                    $user->notify(new \App\Notifications\ContentWarningNotification($warning));
                }
                break;
                
            case 'ban_user':
                if ($user) {
                    // Ban the user
                    $user->ban(
                        $flag->admin_notes ?? "Banned due to flagged content: {$flag->reason_label}",
                        Auth::id()
                    );

                    // Mark all user's content as reported
                    \App\Models\ForumPost::where('user_id', $user->id)->update(['is_reported' => true]);
                    \App\Models\ForumComment::where('user_id', $user->id)->update(['is_reported' => true]);

                    // Send notification
                    $user->notify(new \App\Notifications\UserBannedNotification(
                        $flag->admin_notes ?? "Banned due to flagged content: {$flag->reason_label}",
                        Auth::user()->name
                    ));
                }
                break;
        }
    }

    /**
     * Bulk update flags
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'flag_ids' => 'required|array',
            'flag_ids.*' => 'exists:content_flags,id',
            'status' => 'required|in:reviewed,dismissed,action_taken',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        ContentFlag::whereIn('id', $request->flag_ids)
            ->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);

        $count = count($request->flag_ids);
        return redirect()->route('admin.content-flags.index')
            ->with('success', "Successfully updated {$count} flags.");
    }
}