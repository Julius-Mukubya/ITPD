<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('created_by', auth()->id())
            ->withCount('participants')
            ->latest()
            ->paginate(10);

        return view('teacher.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('teacher.campaigns.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign = Campaign::create($validated);

        return redirect()->route('teacher.campaigns.show', $campaign)
            ->with('success', 'Campaign created successfully!');
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $campaign->load(['participants.user', 'contact']);
        
        $participantIds = $campaign->participants()->pluck('user_id')->filter();
        
        $stats = [
            'total_participants' => $campaign->participants()->count(),
            'assessment_attempts' => \App\Models\AssessmentAttempt::whereIn('user_id', $participantIds)->count(),
            'content_views' => \App\Models\ContentView::whereIn('user_id', $participantIds)->count(),
            'counseling_sessions' => \App\Models\CounselingSession::whereIn('student_id', $participantIds)->count(),
        ];

        return view('teacher.campaigns.show', compact('campaign', 'stats'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return view('teacher.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'nullable|string',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('campaigns', 'public');
        }

        $campaign->update($validated);

        return redirect()->route('teacher.campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);

        $campaign->delete();

        return redirect()->route('teacher.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}
