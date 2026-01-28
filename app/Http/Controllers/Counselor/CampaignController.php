<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of counselor's own campaigns.
     */
    public function index()
    {
        $campaigns = Campaign::where('created_by', auth()->id())
            ->with(['participants'])
            ->latest()
            ->paginate(10);

        return view('counselor.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('counselor.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_office' => 'nullable|string|max:255',
            'contact_hours' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('campaign-images', 'public');
        }

        Campaign::create($data);

        return redirect()->route('counselor.campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        // Ensure counselor can only view their own campaigns
        if ($campaign->created_by !== auth()->id()) {
            abort(403, 'You can only view your own campaigns.');
        }

        $campaign->load(['participants.user']);
        
        return view('counselor.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        // Ensure counselor can only edit their own campaigns
        if ($campaign->created_by !== auth()->id()) {
            abort(403, 'You can only edit your own campaigns.');
        }

        return view('counselor.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        // Ensure counselor can only update their own campaigns
        if ($campaign->created_by !== auth()->id()) {
            abort(403, 'You can only update your own campaigns.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_office' => 'nullable|string|max:255',
            'contact_hours' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('campaign-images', 'public');
        }

        $campaign->update($data);

        return redirect()->route('counselor.campaigns.index')
            ->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        // Ensure counselor can only delete their own campaigns
        if ($campaign->created_by !== auth()->id()) {
            abort(403, 'You can only delete your own campaigns.');
        }

        $campaign->delete();

        return redirect()->route('counselor.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}