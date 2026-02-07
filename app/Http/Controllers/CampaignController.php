<?php

namespace App\Http\Controllers;

use App\Models\{Campaign, CampaignParticipant};
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $activeCampaigns = Campaign::active()
            ->withCount('participants')
            ->latest()
            ->paginate(9);

        $upcomingCampaigns = Campaign::upcoming()
            ->withCount('participants')
            ->latest('start_date')
            ->take(6)
            ->get();

        // Add completed campaigns
        $completedCampaigns = Campaign::where('status', 'active')
            ->where('end_date', '<', now())
            ->withCount('participants')
            ->latest('end_date')
            ->take(6)
            ->get();

        // Add registration status for authenticated users
        if (auth()->check()) {
            $userRegistrations = CampaignParticipant::where('user_id', auth()->id())
                ->where('status', 'registered')
                ->pluck('campaign_id')
                ->toArray();
            
            // Add registration status to campaigns
            foreach ($activeCampaigns as $campaign) {
                $campaign->is_user_registered = in_array($campaign->id, $userRegistrations);
            }
            
            foreach ($upcomingCampaigns as $campaign) {
                $campaign->is_user_registered = in_array($campaign->id, $userRegistrations);
            }

            foreach ($completedCampaigns as $campaign) {
                $campaign->is_user_registered = in_array($campaign->id, $userRegistrations);
            }
        }

        return view('public.campaigns.index', compact('activeCampaigns', 'upcomingCampaigns', 'completedCampaigns'));
    }

    public function show(Campaign $campaign)
    {
        $campaign->load('creator', 'contacts');
        $campaign->loadCount('participants');

        $isRegistered = auth()->check() && $campaign->isUserRegistered(auth()->id());

        return view('public.campaigns.show', compact('campaign', 'isRegistered'));
    }

    public function sample($slug)
    {
        $sampleCampaigns = [
            'mindful-wellness-week' => [
                'title' => 'Mindful Wellness Week',
                'description' => 'A week of workshops and activities focused on mindfulness and mental wellbeing for the entire community.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCQdHhFVpCBX4Q5EGNw3RdftiN2fwUgFUS919IFT7JEBvjfXxPIBLTEnjQActl7TraQPUBgmXplBJb2Pjvz2itAZ1hermfsU0ydpI_hzG4SD45iK0ESo0hq-ZSEBIbIGJqJnfBCAEIxZv1hppVevdXx7NsVqIbBaAaHa6-BUr4RB9kZ90la4rHKRbSsyD3GpKnd6asNsz8liPiD_LAKttcKoOFbUTMtZqb2XMIQbYtyVxq35su6hMSca8rMoIouzXmiWHmUSQ11Pg',
                'type' => 'Wellness',
                'dates' => 'Oct 10 - Oct 17, 2024',
                'participants' => 120,
                'duration' => 7,
                'goals' => 'To introduce students to mindfulness practices, reduce stress levels across campus, and create a supportive community focused on mental wellbeing. We aim to provide practical tools that students can use throughout their academic journey.',
                'target_audience' => 'All students, especially those experiencing academic stress, anxiety, or looking to improve their mental wellness. No prior experience with mindfulness required - beginners are welcome!',
                'timeline' => [
                    [
                        'title' => 'Campaign Launch',
                        'date' => 'October 10, 2024 at 9:00 AM',
                        'description' => 'Opening ceremony with introduction to mindfulness and week overview.',
                        'icon' => 'play_arrow',
                        'color' => 'bg-primary'
                    ],
                    [
                        'title' => 'Daily Workshops',
                        'date' => 'October 11-16, 2024',
                        'description' => 'Daily mindfulness sessions, meditation workshops, and stress management techniques.',
                        'icon' => 'self_improvement',
                        'color' => 'bg-blue-500'
                    ],
                    [
                        'title' => 'Closing Celebration',
                        'date' => 'October 17, 2024 at 6:00 PM',
                        'description' => 'Community gathering to share experiences and celebrate progress made.',
                        'icon' => 'celebration',
                        'color' => 'bg-green-500'
                    ]
                ],
                'features' => [
                    ['icon' => 'self_improvement', 'title' => 'Daily Meditation', 'description' => 'Guided sessions every morning'],
                    ['icon' => 'psychology', 'title' => 'Stress Management', 'description' => 'Practical coping techniques'],
                    ['icon' => 'groups', 'title' => 'Peer Support', 'description' => 'Connect with like-minded students'],
                    ['icon' => 'certificate', 'title' => 'Completion Certificate', 'description' => 'Recognition for participation']
                ]
            ],
            'sober-socials-kickoff' => [
                'title' => 'Sober Socials Kick-off',
                'description' => 'Join us for a fun, alcohol-free social event to connect with peers and build meaningful relationships.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBvkUuNFWggMwp0Pqx1vORN9BGGMYwdsqeHGsPOldg4r5tkE28uGNdiE9yY_zYf1qX_-_66buXZ48u9CXcPCv-i3-T3S6mmmDVzXixcSJtJv3cZE4WGvTtAac3-B5vgj1qQuBBbrkTyD1rxZt-9g7C3JdD06ZUHfqUYvSet_lprDK5xMCeTr1HwE79QL0to803xWO5l55n3m0fCgR6L8gp9sfYwh-kq0QM6U6lx6qp5D5HZoHu1NcojHFlJXds6tzbFCWdG_gK6fg',
                'type' => 'Social',
                'dates' => 'Nov 5, 2024',
                'participants' => 85,
                'duration' => 1,
                'goals' => 'To create a vibrant social environment where students can have fun, make connections, and enjoy activities without alcohol. We want to show that socializing can be just as enjoyable and meaningful in a sober setting.',
                'target_audience' => 'All students who want to socialize in an alcohol-free environment. Perfect for those in recovery, those who choose not to drink, or anyone looking for alternative social activities.',
                'timeline' => [
                    [
                        'title' => 'Event Setup',
                        'date' => 'November 5, 2024 at 5:00 PM',
                        'description' => 'Venue preparation and welcome activities begin.',
                        'icon' => 'event_available',
                        'color' => 'bg-primary'
                    ],
                    [
                        'title' => 'Main Activities',
                        'date' => 'November 5, 2024 at 6:00 PM',
                        'description' => 'Games, music, food, and networking activities in full swing.',
                        'icon' => 'celebration',
                        'color' => 'bg-blue-500'
                    ],
                    [
                        'title' => 'Wrap-up',
                        'date' => 'November 5, 2024 at 10:00 PM',
                        'description' => 'Event conclusion with feedback collection and future planning.',
                        'icon' => 'handshake',
                        'color' => 'bg-green-500'
                    ]
                ],
                'features' => [
                    ['icon' => 'sports_esports', 'title' => 'Fun Games', 'description' => 'Board games, video games, trivia'],
                    ['icon' => 'restaurant', 'title' => 'Great Food', 'description' => 'Delicious snacks and mocktails'],
                    ['icon' => 'music_note', 'title' => 'Live Music', 'description' => 'Local student performances'],
                    ['icon' => 'diversity_3', 'title' => 'Networking', 'description' => 'Meet new friends and connections']
                ]
            ],
            'stress-less-live-more' => [
                'title' => 'Stress Less, Live More',
                'description' => 'Learn effective stress management techniques for a balanced student life through interactive workshops.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCrL5rYa5Fsgj4frnmmGoRtIwWcGZli8mm9qA-lxjAvnNKxnslyVciwpVTr8zRPVp2Gg6z4X-BxR_6MYWaU95sYdIe3yNYI8IL9QXQG1PdBifCZvegAZeHDIQnLd8mimOaw3mKgQfsuqQtA90HA-d6GPDKjJS9W8Q-B_0--DYJRXYAP_6zjxA9YtcVMCyXj--UnMCGlC-hNCcuf-oukgRYbYDKBTUhDk-z_QXnShiF0BdxTvVvH37PBbfZi_vohUT4Uqd6o33v2aw',
                'type' => 'Educational',
                'dates' => 'Oct 20 - Oct 27, 2024',
                'participants' => 95,
                'duration' => 7,
                'goals' => 'To equip students with practical stress management tools, improve academic performance through better stress handling, and promote overall mental health and wellbeing across the community.',
                'target_audience' => 'Students experiencing academic pressure, those preparing for exams, anyone dealing with life transitions, and students who want to develop better coping mechanisms for daily challenges.',
                'timeline' => [
                    [
                        'title' => 'Stress Assessment',
                        'date' => 'October 20, 2024 at 2:00 PM',
                        'description' => 'Initial stress level assessment and goal setting session.',
                        'icon' => 'assessment',
                        'color' => 'bg-primary'
                    ],
                    [
                        'title' => 'Workshop Series',
                        'date' => 'October 21-26, 2024',
                        'description' => 'Daily workshops covering different stress management techniques.',
                        'icon' => 'school',
                        'color' => 'bg-blue-500'
                    ],
                    [
                        'title' => 'Progress Review',
                        'date' => 'October 27, 2024 at 4:00 PM',
                        'description' => 'Final assessment and personalized stress management plan creation.',
                        'icon' => 'trending_up',
                        'color' => 'bg-green-500'
                    ]
                ],
                'features' => [
                    ['icon' => 'psychology', 'title' => 'Coping Strategies', 'description' => 'Evidence-based techniques'],
                    ['icon' => 'fitness_center', 'title' => 'Physical Wellness', 'description' => 'Exercise and relaxation methods'],
                    ['icon' => 'schedule', 'title' => 'Time Management', 'description' => 'Organize your academic life'],
                    ['icon' => 'support', 'title' => 'Ongoing Support', 'description' => 'Continued guidance and resources']
                ]
            ]
        ];

        if (!isset($sampleCampaigns[$slug])) {
            abort(404);
        }

        $sampleCampaign = $sampleCampaigns[$slug];

        return view('public.campaigns.sample', compact('sampleCampaign'));
    }

    public function register(Campaign $campaign, Request $request)
    {
        // Check if campaign is full
        if ($campaign->isFull()) {
            return back()->with('error', 'This campaign is full.');
        }

        // Handle authenticated user registration
        if (auth()->check()) {
            if ($campaign->isUserRegistered(auth()->id())) {
                return back()->with('error', 'You are already registered for this campaign.');
            }

            CampaignParticipant::create([
                'campaign_id' => $campaign->id,
                'user_id' => auth()->id(),
                'status' => 'registered',
                'registered_at' => now(),
            ]);

            return back()->with('success', 'Successfully registered for the campaign!');
        }

        // Handle guest registration
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'motivation' => 'nullable|string|max:1000',
        ]);

        // Check if email is already registered for this campaign
        $existingRegistration = CampaignParticipant::where('campaign_id', $campaign->id)
            ->where('guest_email', $validated['guest_email'])
            ->where('is_guest_registration', true)
            ->first();

        if ($existingRegistration) {
            return back()->with('error', 'This email is already registered for this campaign.');
        }

        CampaignParticipant::create([
            'campaign_id' => $campaign->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'motivation' => $validated['motivation'],
            'is_guest_registration' => true,
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Successfully registered for the campaign! You will receive updates at ' . $validated['guest_email']);
    }

    public function unregister(Campaign $campaign)
    {
        if (!auth()->check()) {
            abort(403);
        }

        $participant = CampaignParticipant::where([
            'campaign_id' => $campaign->id,
            'user_id' => auth()->id(),
        ])->first();

        if (!$participant) {
            return back()->with('error', 'You are not registered for this campaign.');
        }

        $participant->update(['status' => 'cancelled']);

        return back()->with('success', 'Successfully unregistered from the campaign.');
    }
}