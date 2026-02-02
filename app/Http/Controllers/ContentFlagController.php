<?php

namespace App\Http\Controllers;

use App\Models\ContentFlag;
use App\Models\ForumPost;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentFlagController extends Controller
{
    /**
     * Store a new content flag
     */
    public function store(Request $request)
    {
        $request->validate([
            'flaggable_type' => 'required|string|in:App\Models\ForumPost,App\Models\ForumComment',
            'flaggable_id' => 'required|integer',
            'reason' => 'required|string|in:inappropriate_content,harassment,spam,misinformation,hate_speech,violence,self_harm,other',
            'description' => 'nullable|string|max:500',
        ]);

        // Check if content exists
        $model = $request->flaggable_type;
        $content = $model::find($request->flaggable_id);
        
        if (!$content) {
            return response()->json([
                'success' => false,
                'message' => 'Content not found.'
            ], 404);
        }

        // Check if user already flagged this content
        $existingFlag = ContentFlag::where([
            'user_id' => Auth::id(),
            'flaggable_type' => $request->flaggable_type,
            'flaggable_id' => $request->flaggable_id,
        ])->first();

        if ($existingFlag) {
            return response()->json([
                'success' => false,
                'message' => 'You have already flagged this content.'
            ], 422);
        }

        // Create the flag
        $flag = ContentFlag::create([
            'user_id' => Auth::id(),
            'flaggable_type' => $request->flaggable_type,
            'flaggable_id' => $request->flaggable_id,
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        // Update the content's is_reported flag if it's the first flag
        if ($content->flags()->count() === 1) {
            $content->update(['is_reported' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Content has been flagged for review. Thank you for helping keep our community safe.',
            'flag_id' => $flag->id
        ]);
    }

    /**
     * Remove a flag (unflag content)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'flaggable_type' => 'required|string|in:App\Models\ForumPost,App\Models\ForumComment',
            'flaggable_id' => 'required|integer',
        ]);

        $flag = ContentFlag::where([
            'user_id' => Auth::id(),
            'flaggable_type' => $request->flaggable_type,
            'flaggable_id' => $request->flaggable_id,
        ])->first();

        if (!$flag) {
            return response()->json([
                'success' => false,
                'message' => 'Flag not found.'
            ], 404);
        }

        // Only allow removal if flag is still pending
        if ($flag->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot remove a flag that has already been reviewed.'
            ], 422);
        }

        $flag->delete();

        // Update content's is_reported flag if no more flags exist
        $model = $request->flaggable_type;
        $content = $model::find($request->flaggable_id);
        if ($content && $content->flags()->count() === 0) {
            $content->update(['is_reported' => false]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Flag removed successfully.'
        ]);
    }
}