<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\{Campaign, CampaignParticipant, ContentView, EducationalContent, AssessmentAttempt, Assessment, ForumPost, ForumComment, ContentReview};
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function content()
    {
        // Get ALL regular user (student) IDs
        $studentRole = 'user';

        $data = [
            'total_views' => ContentView::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->count(),
            'this_week_views' => ContentView::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->where('viewed_at', '>=', now()->subWeek())->count(),
            'unique_students' => ContentView::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->distinct('user_id')->count(),
            'avg_time' => ContentView::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->join('educational_contents', 'content_views.content_id', '=', 'educational_contents.id')
                ->avg('educational_contents.reading_time') ?? 0,
            'total_bookmarks' => \App\Models\Bookmark::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->where('bookmarkable_type', EducationalContent::class)->count(),
            'total_reviews' => ContentReview::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->count(),
            'this_week_reviews' => ContentReview::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->where('created_at', '>=', now()->subWeek())->count(),
            'avg_rating' => ContentReview::whereHas('user', function($q) use ($studentRole) {
                $q->where('role', $studentRole);
            })->where('is_approved', true)->avg('rating') ?? 0,
            
            'most_viewed' => EducationalContent::withCount([
                    'contentViews as student_views_count' => function($query) use ($studentRole) {
                        $query->whereHas('user', function($q) use ($studentRole) {
                            $q->where('role', $studentRole);
                        });
                    },
                    'contentViews as unique_students_count' => function($query) use ($studentRole) {
                        $query->whereHas('user', function($q) use ($studentRole) {
                            $q->where('role', $studentRole);
                        })->distinct('user_id');
                    },
                    'reviews as reviews_count' => function($query) use ($studentRole) {
                        $query->whereHas('user', function($q) use ($studentRole) {
                            $q->where('role', $studentRole);
                        })->where('is_approved', true);
                    }
                ])
                ->with('category')
                ->having('student_views_count', '>', 0)
                ->orderBy('student_views_count', 'desc')
                ->take(10)
                ->get(),
            
            'category_breakdown' => ContentView::whereHas('user', function($q) use ($studentRole) {
                    $q->where('role', $studentRole);
                })
                ->join('educational_contents', 'content_views.content_id', '=', 'educational_contents.id')
                ->join('categories', 'educational_contents.category_id', '=', 'categories.id')
                ->select('categories.name', \DB::raw('count(*) as count'))
                ->groupBy('categories.name')
                ->pluck('count', 'name')
                ->toArray(),
            
            'rating_distribution' => ContentReview::whereHas('user', function($q) use ($studentRole) {
                    $q->where('role', $studentRole);
                })
                ->where('is_approved', true)
                ->select('rating', \DB::raw('count(*) as count'))
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray(),
        ];

        return view('teacher.content', $data);
    }

    public function assessments()
    {
        // Get ALL regular users (students) instead of filtering by campaigns
        $allStudents = \App\Models\User::where('role', 'user')->pluck('id');

        $totalAttempts = AssessmentAttempt::whereIn('user_id', $allStudents)->count();
        $activeStudents = AssessmentAttempt::whereIn('user_id', $allStudents)
            ->distinct('user_id')->count();

        $data = [
            'total_attempts' => $totalAttempts,
            'this_week_attempts' => AssessmentAttempt::whereIn('user_id', $allStudents)
                ->where('created_at', '>=', now()->subWeek())->count(),
            'active_students' => $activeStudents,
            'completion_rate' => $totalAttempts > 0 
                ? round((AssessmentAttempt::whereIn('user_id', $allStudents)->whereNotNull('taken_at')->count() / $totalAttempts) * 100)
                : 0,
            'avg_per_student' => $activeStudents > 0 ? round($totalAttempts / $activeStudents, 1) : 0,
            
            'type_distribution' => AssessmentAttempt::whereIn('user_id', $allStudents)
                ->join('assessments', 'assessment_attempts.assessment_id', '=', 'assessments.id')
                ->select('assessments.type', \DB::raw('count(*) as count'))
                ->groupBy('assessments.type')
                ->pluck('count', 'type')
                ->toArray(),
            
            'popular_assessments' => Assessment::withCount([
                    'attempts as attempts_count' => function($query) use ($allStudents) {
                        $query->whereIn('user_id', $allStudents);
                    },
                    'attempts as unique_students_count' => function($query) use ($allStudents) {
                        $query->whereIn('user_id', $allStudents)->distinct('user_id');
                    }
                ])
                ->having('attempts_count', '>', 0)
                ->orderBy('attempts_count', 'desc')
                ->take(10)
                ->get(),
            
            'weekly_trend' => $this->getWeeklyAssessmentTrend($allStudents),
        ];

        return view('teacher.assessments', $data);
    }

    public function forum()
    {
        // Get ALL regular users (students) instead of filtering by campaigns
        $allStudents = \App\Models\User::where('role', 'user')->pluck('id');

        $totalPosts = ForumPost::whereIn('user_id', $allStudents)->count();
        $activeStudents = ForumPost::whereIn('user_id', $allStudents)
            ->distinct('user_id')->count();

        $data = [
            'total_posts' => $totalPosts,
            'this_week_posts' => ForumPost::whereIn('user_id', $allStudents)
                ->where('created_at', '>=', now()->subWeek())->count(),
            'total_comments' => ForumComment::whereIn('user_id', $allStudents)->count(),
            'this_week_comments' => ForumComment::whereIn('user_id', $allStudents)
                ->where('created_at', '>=', now()->subWeek())->count(),
            'active_students' => $activeStudents,
            'engagement_rate' => $allStudents->count() > 0 
                ? round(($activeStudents / $allStudents->count()) * 100)
                : 0,
            
            'category_activity' => ForumPost::whereIn('user_id', $allStudents)
                ->join('forum_categories', 'forum_posts.category_id', '=', 'forum_categories.id')
                ->select('forum_categories.name', \DB::raw('count(*) as count'))
                ->groupBy('forum_categories.name')
                ->pluck('count', 'name')
                ->toArray(),
            
            'recent_posts' => ForumPost::whereIn('user_id', $allStudents)
                ->with('category')
                ->withCount('comments')
                ->latest()
                ->take(10)
                ->get(),
            
            'weekly_activity' => $this->getWeeklyForumActivity($allStudents),
        ];

        return view('teacher.forum', $data);
    }

    public function reports()
    {
        $teacherCampaigns = Campaign::where('created_by', auth()->id())->pluck('id');
        
        // Get ALL regular users (students) in the system
        $allStudents = \App\Models\User::where('role', 'user')->pluck('id');

        // Overall stats
        $stats = [
            'total_students' => $allStudents->count(),
            'total_campaigns' => $teacherCampaigns->count(),
            'active_campaigns' => Campaign::whereIn('id', $teacherCampaigns)
                ->where('end_date', '>=', now())->count(),
            
            // Content engagement
            'total_content_views' => ContentView::whereIn('user_id', $allStudents)->count(),
            'unique_content_viewers' => ContentView::whereIn('user_id', $allStudents)
                ->distinct('user_id')->count(),
            'total_bookmarks' => \App\Models\Bookmark::whereIn('user_id', $allStudents)
                ->where('bookmarkable_type', EducationalContent::class)->count(),
            'total_reviews' => ContentReview::whereIn('user_id', $allStudents)->count(),
            
            // Assessment stats
            'total_assessments' => AssessmentAttempt::whereIn('user_id', $allStudents)->count(),
            'completed_assessments' => AssessmentAttempt::whereIn('user_id', $allStudents)
                ->whereNotNull('taken_at')->count(),
            'assessment_takers' => AssessmentAttempt::whereIn('user_id', $allStudents)
                ->distinct('user_id')->count(),
            
            // Forum stats
            'total_posts' => ForumPost::whereIn('user_id', $allStudents)->count(),
            'total_comments' => ForumComment::whereIn('user_id', $allStudents)->count(),
            'forum_participants' => ForumPost::whereIn('user_id', $allStudents)
                ->distinct('user_id')->count(),
        ];

        // Calculate engagement rate
        $stats['engagement_rate'] = $stats['total_students'] > 0 
            ? round((($stats['unique_content_viewers'] + $stats['assessment_takers'] + $stats['forum_participants']) / ($stats['total_students'] * 3)) * 100)
            : 0;

        // Weekly trends
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weeklyData[] = [
                'date' => $date->format('M d'),
                'views' => ContentView::whereIn('user_id', $allStudents)
                    ->whereDate('viewed_at', $date)->count(),
                'assessments' => AssessmentAttempt::whereIn('user_id', $allStudents)
                    ->whereDate('created_at', $date)->count(),
                'posts' => ForumPost::whereIn('user_id', $allStudents)
                    ->whereDate('created_at', $date)->count(),
            ];
        }

        // Top performing content
        $topContent = EducationalContent::withCount([
                'contentViews as views_count' => function($query) use ($allStudents) {
                    $query->whereIn('user_id', $allStudents);
                }
            ])
            ->with('category')
            ->having('views_count', '>', 0)
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        // Campaign performance
        $campaignPerformance = Campaign::whereIn('id', $teacherCampaigns)
            ->withCount([
                'participants as total_participants',
                'participants as active_participants' => function($query) {
                    $query->whereHas('user', function($q) {
                        $q->whereHas('contentViews', function($cv) {
                            $cv->where('viewed_at', '>=', now()->subWeek());
                        });
                    });
                }
            ])
            ->get();

        return view('teacher.reports', compact('stats', 'weeklyData', 'topContent', 'campaignPerformance'));
    }

    public function exportReports()
    {
        $teacherCampaigns = Campaign::where('created_by', auth()->id())->pluck('id');
        
        // Get ALL regular users (students) in the system
        $allStudents = \App\Models\User::where('role', 'user')->pluck('id');

        // Prepare CSV data
        $csvData = [];
        
        // Header
        $csvData[] = ['Teacher Reports - Generated on ' . now()->format('Y-m-d H:i:s')];
        $csvData[] = ['Teacher: ' . auth()->user()->name];
        $csvData[] = [];
        
        // Overall Statistics
        $csvData[] = ['OVERALL STATISTICS'];
        $csvData[] = ['Metric', 'Value'];
        $csvData[] = ['Total Students', $allStudents->count()];
        $csvData[] = ['Total Campaigns', $teacherCampaigns->count()];
        $csvData[] = ['Active Campaigns', Campaign::whereIn('id', $teacherCampaigns)->where('end_date', '>=', now())->count()];
        $csvData[] = [];
        
        // Content Engagement
        $csvData[] = ['CONTENT ENGAGEMENT'];
        $csvData[] = ['Metric', 'Value'];
        $csvData[] = ['Total Views', ContentView::whereIn('user_id', $allStudents)->count()];
        $csvData[] = ['Unique Viewers', ContentView::whereIn('user_id', $allStudents)->distinct('user_id')->count()];
        $csvData[] = ['Total Bookmarks', \App\Models\Bookmark::whereIn('user_id', $allStudents)->where('bookmarkable_type', EducationalContent::class)->count()];
        $csvData[] = ['Total Reviews', ContentReview::whereIn('user_id', $allStudents)->count()];
        $csvData[] = [];
        
        // Assessment Activity
        $csvData[] = ['ASSESSMENT ACTIVITY'];
        $csvData[] = ['Metric', 'Value'];
        $csvData[] = ['Total Attempts', AssessmentAttempt::whereIn('user_id', $allStudents)->count()];
        $csvData[] = ['Completed Attempts', AssessmentAttempt::whereIn('user_id', $allStudents)->whereNotNull('taken_at')->count()];
        $csvData[] = ['Unique Participants', AssessmentAttempt::whereIn('user_id', $allStudents)->distinct('user_id')->count()];
        $csvData[] = [];
        
        // Forum Participation
        $csvData[] = ['FORUM PARTICIPATION'];
        $csvData[] = ['Metric', 'Value'];
        $csvData[] = ['Total Posts', ForumPost::whereIn('user_id', $allStudents)->count()];
        $csvData[] = ['Total Comments', ForumComment::whereIn('user_id', $allStudents)->count()];
        $csvData[] = ['Active Participants', ForumPost::whereIn('user_id', $allStudents)->distinct('user_id')->count()];
        $csvData[] = [];
        
        // Top Content
        $csvData[] = ['TOP PERFORMING CONTENT'];
        $csvData[] = ['Title', 'Category', 'Views'];
        $topContent = EducationalContent::withCount([
                'contentViews as views_count' => function($query) use ($allStudents) {
                    $query->whereIn('user_id', $allStudents);
                }
            ])
            ->with('category')
            ->having('views_count', '>', 0)
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();
        
        foreach ($topContent as $content) {
            $csvData[] = [$content->title, $content->category->name ?? 'N/A', $content->views_count];
        }
        $csvData[] = [];
        
        // Campaign Performance
        $csvData[] = ['CAMPAIGN PERFORMANCE'];
        $csvData[] = ['Campaign', 'Status', 'Total Participants', 'Active This Week'];
        $campaigns = Campaign::whereIn('id', $teacherCampaigns)
            ->withCount([
                'participants as total_participants',
                'participants as active_participants' => function($query) {
                    $query->whereHas('user', function($q) {
                        $q->whereHas('contentViews', function($cv) {
                            $cv->where('viewed_at', '>=', now()->subWeek());
                        });
                    });
                }
            ])
            ->get();
        
        foreach ($campaigns as $campaign) {
            $csvData[] = [
                $campaign->title,
                $campaign->end_date >= now() ? 'Active' : 'Ended',
                $campaign->total_participants,
                $campaign->active_participants
            ];
        }
        
        // Generate CSV
        $filename = 'teacher_report_' . now()->format('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getWeeklyAssessmentTrend($studentIds)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = AssessmentAttempt::whereIn('user_id', $studentIds)
                ->whereDate('created_at', $date)->count();
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }
        return $data;
    }

    private function getWeeklyForumActivity($studentIds)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $posts = ForumPost::whereIn('user_id', $studentIds)->whereDate('created_at', $date)->count();
            $comments = ForumComment::whereIn('user_id', $studentIds)->whereDate('created_at', $date)->count();
            $data[] = [
                'date' => $date->format('M d'),
                'posts' => $posts,
                'comments' => $comments
            ];
        }
        return $data;
    }
}
