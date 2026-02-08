<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EducationalContent;
use App\Models\Assessment;
use App\Models\Campaign;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->get('q', '');
            
            if (empty($query) || strlen($query) < 2) {
                return response()->json([
                    'results' => [],
                    'message' => 'Please enter at least 2 characters to search'
                ]);
            }

            $results = [];

            // Search Users
            try {
                $users = User::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->limit(3)
                            ->get(['id', 'name', 'email', 'role']);

                foreach ($users as $user) {
                    $results[] = [
                        'type' => 'user',
                        'title' => $user->name,
                        'subtitle' => $user->email,
                        'badge' => ucfirst($user->role),
                        'url' => route('admin.users.show', $user->id),
                        'icon' => 'person'
                    ];
                }
            } catch (\Exception $e) {
                // Skip users if there's an error
            }

            // Search Educational Content
            try {
                $contents = EducationalContent::where('title', 'LIKE', "%{$query}%")
                                            ->orWhere('content', 'LIKE', "%{$query}%")
                                            ->limit(3)
                                            ->get(['id', 'title', 'is_published', 'created_at']);

                foreach ($contents as $content) {
                    $results[] = [
                        'type' => 'content',
                        'title' => $content->title,
                        'subtitle' => 'Created ' . $content->created_at->diffForHumans(),
                        'badge' => $content->is_published ? 'Published' : 'Draft',
                        'url' => route('admin.contents.show', $content->id),
                        'icon' => 'article'
                    ];
                }
            } catch (\Exception $e) {
                // Skip content if there's an error
            }

            // Search Assessments
            try {
                $assessments = Assessment::where('name', 'LIKE', "%{$query}%")
                                        ->orWhere('full_name', 'LIKE', "%{$query}%")
                                        ->orWhere('description', 'LIKE', "%{$query}%")
                                        ->limit(3)
                                        ->get(['id', 'name', 'full_name', 'is_active', 'created_at']);

                foreach ($assessments as $assessment) {
                    $results[] = [
                        'type' => 'assessment',
                        'title' => $assessment->full_name ?: $assessment->name,
                        'subtitle' => 'Created ' . $assessment->created_at->diffForHumans(),
                        'badge' => $assessment->is_active ? 'Active' : 'Inactive',
                        'url' => route('admin.assessments.show', $assessment->id),
                        'icon' => 'psychology'
                    ];
                }
            } catch (\Exception $e) {
                // Skip assessments if there's an error
            }

            // Search Campaigns
            try {
                $campaigns = Campaign::where('title', 'LIKE', "%{$query}%")
                                   ->orWhere('description', 'LIKE', "%{$query}%")
                                   ->limit(3)
                                   ->get(['id', 'title', 'status', 'created_at']);

                foreach ($campaigns as $campaign) {
                    $results[] = [
                        'type' => 'campaign',
                        'title' => $campaign->title,
                        'subtitle' => 'Created ' . $campaign->created_at->diffForHumans(),
                        'badge' => ucfirst($campaign->status ?? 'unknown'),
                        'url' => route('admin.campaigns.show', $campaign->id),
                        'icon' => 'campaign'
                    ];
                }
            } catch (\Exception $e) {
                // Skip campaigns if there's an error
            }

            // Search Counseling Sessions
            try {
                $sessions = CounselingSession::with('student')
                                          ->whereHas('student', function($q) use ($query) {
                                              $q->where('name', 'LIKE', "%{$query}%");
                                          })
                                          ->orWhere('session_type', 'LIKE', "%{$query}%")
                                          ->limit(3)
                                          ->get(['id', 'student_id', 'session_type', 'status', 'scheduled_at']);

                foreach ($sessions as $session) {
                    $studentName = $session->student ? $session->student->name : 'Unknown Student';
                    $sessionType = $session->session_type ?? 'session';
                    $scheduledDate = $session->scheduled_at ? $session->scheduled_at->format('M j, Y') : 'No date';
                    
                    $results[] = [
                        'type' => 'session',
                        'title' => 'Session with ' . $studentName,
                        'subtitle' => ucfirst($sessionType) . ' - ' . $scheduledDate,
                        'badge' => ucfirst($session->status ?? 'unknown'),
                        'url' => route('admin.counseling.index') . '?session=' . $session->id,
                        'icon' => 'support_agent'
                    ];
                }
            } catch (\Exception $e) {
                // Skip sessions if there's an error
            }

            // If no results found, provide helpful message
            if (empty($results)) {
                $results[] = [
                    'type' => 'no-results',
                    'title' => 'No results found',
                    'subtitle' => 'Try searching for users, content, assessments, campaigns, or sessions',
                    'badge' => 'Info',
                    'url' => '#',
                    'icon' => 'search_off'
                ];
            }

            // Limit total results to 15
            $results = array_slice($results, 0, 15);

            return response()->json([
                'results' => $results,
                'total' => count($results),
                'query' => $query,
                'debug' => [
                    'users_searched' => true,
                    'content_searched' => true,
                    'assessments_searched' => true,
                    'campaigns_searched' => true,
                    'sessions_searched' => true
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'results' => [
                    [
                        'type' => 'error',
                        'title' => 'Search Error',
                        'subtitle' => $e->getMessage(),
                        'badge' => 'Error',
                        'url' => '#',
                        'icon' => 'error'
                    ]
                ],
                'error' => 'Search failed: ' . $e->getMessage(),
                'query' => $query ?? ''
            ]);
        }
    }

    public function suggestions()
    {
        try {
            $suggestions = [
                [
                    'title' => 'Recent Users',
                    'items' => User::latest()->limit(3)->get(['id', 'name', 'role'])->map(function($user) {
                        return [
                            'title' => $user->name,
                            'subtitle' => ucfirst($user->role),
                            'url' => route('admin.users.show', $user->id),
                            'icon' => 'person'
                        ];
                    })
                ],
                [
                    'title' => 'Quick Actions',
                    'items' => [
                        [
                            'title' => 'Create Content',
                            'subtitle' => 'Add new educational content',
                            'url' => route('admin.contents.create'),
                            'icon' => 'add'
                        ],
                        [
                            'title' => 'Add User',
                            'subtitle' => 'Create new user account',
                            'url' => route('admin.users.create'),
                            'icon' => 'person_add'
                        ],
                        [
                            'title' => 'View Reports',
                            'subtitle' => 'System analytics and reports',
                            'url' => route('admin.reports.index'),
                            'icon' => 'summarize'
                        ]
                    ]
                ]
            ];

            return response()->json(['suggestions' => $suggestions]);
        } catch (\Exception $e) {
            return response()->json([
                'suggestions' => [],
                'error' => 'Failed to load suggestions: ' . $e->getMessage()
            ], 500);
        }
    }
}