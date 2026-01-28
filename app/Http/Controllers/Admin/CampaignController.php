<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('creator')
            ->withCount('participants')
            ->latest()
            ->paginate(15);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create');
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('creator', 'participants', 'contacts');
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'banner_image' => 'nullable|image|max:2048',
                'type' => 'required|in:awareness,event,workshop,webinar',
                'start_date' => 'required|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_date' => 'required|date',
                'end_time' => 'nullable|date_format:H:i',
                'location' => 'nullable|string',
                'max_participants' => 'nullable|integer|min:1',
                'status' => 'required|in:draft,active,completed,cancelled',
                'is_featured' => 'boolean',
                // Contact validation
                'contacts' => 'required|array|min:1',
                'contacts.*.name' => 'required|string|max:255',
                'contacts.*.title' => 'nullable|string|max:255',
                'contacts.*.email' => 'required|email|max:255',
                'contacts.*.phone' => 'required|string|max:20',
                'contacts.*.office_location' => 'nullable|string|max:255',
                'contacts.*.office_hours' => 'nullable|string|max:255',
                'contacts.*.is_primary' => 'boolean',
            ]);

            // Custom validation for datetime comparison
            $startDateTime = $request->start_date . ' ' . ($request->start_time ?? '00:00');
            $endDateTime = $request->end_date . ' ' . ($request->end_time ?? '23:59');
            
            if (strtotime($endDateTime) <= strtotime($startDateTime)) {
                return redirect()->back()
                    ->withErrors(['end_date' => 'The end date and time must be after the start date and time.'])
                    ->withInput();
            }

            $validated['created_by'] = auth()->id();

            if ($request->hasFile('banner_image')) {
                $validated['banner_image'] = $request->file('banner_image')
                    ->store('campaign-banners', 'public');
            }

            // Remove contacts from main data
            $contacts = $validated['contacts'];
            unset($validated['contacts']);

            $campaign = Campaign::create($validated);

            // Create contacts
            $this->createCampaignContacts($campaign, $contacts);

            return redirect()->route('admin.campaigns.index')
                ->with('success', 'Campaign "' . $campaign->title . '" created successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating campaign: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Campaign $campaign)
    {
        $campaign->load('contacts');
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|image|max:2048',
            'type' => 'required|in:awareness,event,workshop,webinar',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'required|date',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string',
            'max_participants' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,active,completed,cancelled',
            'is_featured' => 'boolean',
            // Contact validation
            'contacts' => 'required|array|min:1',
            'contacts.*.name' => 'required|string|max:255',
            'contacts.*.title' => 'nullable|string|max:255',
            'contacts.*.email' => 'required|email|max:255',
            'contacts.*.phone' => 'required|string|max:20',
            'contacts.*.office_location' => 'nullable|string|max:255',
            'contacts.*.office_hours' => 'nullable|string|max:255',
            'contacts.*.is_primary' => 'boolean',
        ]);

        // Custom validation for datetime comparison
        $startDateTime = $request->start_date . ' ' . ($request->start_time ?? '00:00');
        $endDateTime = $request->end_date . ' ' . ($request->end_time ?? '23:59');
        
        if (strtotime($endDateTime) <= strtotime($startDateTime)) {
            return redirect()->back()
                ->withErrors(['end_date' => 'The end date and time must be after the start date and time.'])
                ->withInput();
        }

        if ($request->hasFile('banner_image')) {
            if ($campaign->banner_image) {
                Storage::disk('public')->delete($campaign->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')
                ->store('campaign-banners', 'public');
        }

        // Remove contacts from main data
        $contacts = $validated['contacts'];
        unset($validated['contacts']);

        $campaign->update($validated);

        // Update contacts
        $campaign->contacts()->delete(); // Remove existing contacts
        $this->createCampaignContacts($campaign, $contacts);

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign updated successfully!');
    }

    private function createCampaignContacts($campaign, $contacts)
    {
        $hasPrimary = false;
        
        foreach ($contacts as $index => $contactData) {
            // Ensure only one primary contact
            if (isset($contactData['is_primary']) && $contactData['is_primary']) {
                if ($hasPrimary) {
                    $contactData['is_primary'] = false;
                } else {
                    $hasPrimary = true;
                }
            }
            
            $campaign->contacts()->create([
                'name' => $contactData['name'],
                'title' => $contactData['title'] ?? null,
                'email' => $contactData['email'],
                'phone' => $contactData['phone'],
                'office_location' => $contactData['office_location'] ?? null,
                'office_hours' => $contactData['office_hours'] ?? null,
                'is_primary' => $contactData['is_primary'] ?? false,
                'sort_order' => $index,
            ]);
        }
        
        // If no primary contact was set, make the first one primary
        if (!$hasPrimary && $campaign->contacts()->count() > 0) {
            $campaign->contacts()->first()->update(['is_primary' => true]);
        }
    }

    public function destroy(Campaign $campaign)
    {
        if ($campaign->banner_image) {
            Storage::disk('public')->delete($campaign->banner_image);
        }

        $campaign->delete();

        return redirect()->route('admin.campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}