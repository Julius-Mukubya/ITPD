<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, EducationalContent, Quiz, QuizAttempt, AssessmentAttempt, CounselingSession};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request, default to 30 days
        $days = $request->input('days', 30);
        $dateFrom = now()->subDays($days);
        
        $stats = [
            // User statistics
            'total_users' => User::where('role', 'user')->count(),
            'total_counselors' => User::where('role', 'counselor')->count(),
            'active_users_today' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subDay())->count(),
            'active_users_week' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subWeek())->count(),
            'active_users_month' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subMonth())->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_users_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'user_retention_rate' => User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subWeek())->count() / max(User::count(), 1) * 100,

            // Content statistics (filtered by date range)
            'total_contents' => EducationalContent::count(),
            'published_contents' => EducationalContent::where('is_published', true)->count(),
            'total_views' => EducationalContent::where('created_at', '>=', $dateFrom)->sum('views'),
            'avg_views' => EducationalContent::where('created_at', '>=', $dateFrom)->avg('views'),
            'most_viewed_content' => EducationalContent::where('created_at', '>=', $dateFrom)->orderBy('views', 'desc')->first(),
            'content_engagement_rate' => EducationalContent::where('views', '>', 0)->where('created_at', '>=', $dateFrom)->count() / max(EducationalContent::where('created_at', '>=', $dateFrom)->count(), 1) * 100,

            // Quiz statistics (filtered by date range)
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'total_quiz_attempts' => QuizAttempt::where('created_at', '>=', $dateFrom)->count(),
            'completed_attempts' => QuizAttempt::where('created_at', '>=', $dateFrom)->whereNotNull('completed_at')->count(),
            'avg_quiz_score' => QuizAttempt::where('created_at', '>=', $dateFrom)->whereNotNull('score')->avg('score'),
            'pass_rate' => QuizAttempt::where('created_at', '>=', $dateFrom)->where('passed', true)->count() / max(QuizAttempt::where('created_at', '>=', $dateFrom)->count(), 1) * 100,
            'quiz_completion_rate' => QuizAttempt::where('created_at', '>=', $dateFrom)->whereNotNull('completed_at')->count() / max(QuizAttempt::where('created_at', '>=', $dateFrom)->count(), 1) * 100,

            // Assessment statistics (filtered by date range)
            'total_assessments' => AssessmentAttempt::where('created_at', '>=', $dateFrom)->count(),
            'low_risk_count' => AssessmentAttempt::where('created_at', '>=', $dateFrom)->where('risk_level', 'low')->count(),
            'medium_risk_count' => AssessmentAttempt::where('created_at', '>=', $dateFrom)->where('risk_level', 'medium')->count(),
            'high_risk_count' => AssessmentAttempt::where('created_at', '>=', $dateFrom)->where('risk_level', 'high')->count(),
            'assessments_this_week' => AssessmentAttempt::where('created_at', '>=', now()->subWeek())->count(),

            // Counseling statistics (filtered by date range)
            'total_sessions' => CounselingSession::where('created_at', '>=', $dateFrom)->count(),
            'pending_sessions' => CounselingSession::where('created_at', '>=', $dateFrom)->where('status', 'pending')->count(),
            'active_sessions' => CounselingSession::where('created_at', '>=', $dateFrom)->where('status', 'active')->count(),
            'completed_sessions' => CounselingSession::where('created_at', '>=', $dateFrom)->where('status', 'completed')->count(),
            'avg_session_duration' => CounselingSession::where('created_at', '>=', $dateFrom)
                ->whereNotNull('started_at')
                ->whereNotNull('completed_at')
                ->get()
                ->map(function($session) {
                    return $session->started_at && $session->completed_at 
                        ? $session->started_at->diffInMinutes($session->completed_at) 
                        : 0;
                })
                ->avg() ?? 0,
            'session_satisfaction' => CounselingSession::where('created_at', '>=', $dateFrom)->whereNotNull('rating')->avg('rating') ?? 0,
        ];

        // Enhanced time-based analytics (adjusted for date range)
        $monthsBack = min(12, ceil($days / 30));
        $monthlyUsers = User::where('created_at', '>=', now()->subMonths($monthsBack))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $weeksBack = min(8, ceil($days / 7));
        $weeklyActivity = User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subWeeks($weeksBack))
            ->select(DB::raw('WEEK(last_login_at) as week'), DB::raw('count(*) as count'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Daily engagement for the selected period
        $daysToShow = min($days, 30); // Limit to 30 days for chart readability
        $dailyEngagement = collect(range(0, $daysToShow - 1))->map(function ($i) use ($dateFrom) {
            $date = now()->subDays($i);
            return [
                'date' => $date->format('M d'),
                'users' => User::whereNotNull('last_login_at')->whereDate('last_login_at', $date)->count(),
                'sessions' => CounselingSession::whereDate('created_at', $date)->count(),
                'assessments' => AssessmentAttempt::whereDate('created_at', $date)->count(),
            ];
        })->reverse()->values();

        $monthsBackQuiz = min(6, ceil($days / 30));
        $monthlyQuizAttempts = QuizAttempt::where('created_at', '>=', now()->subMonths($monthsBackQuiz))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Content performance analytics (filtered by date range)
        $contentPerformance = EducationalContent::select('title', 'views', 'created_at')
            ->where('created_at', '>=', $dateFrom)
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        // Risk assessment trends (for the selected period)
        $riskTrends = collect(range(0, min($days, 14) - 1))->map(function ($i) use ($dateFrom) {
            $date = now()->subDays($i);
            return [
                'date' => $date->format('M d'),
                'low' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'low')->count(),
                'medium' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'medium')->count(),
                'high' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'high')->count(),
            ];
        })->reverse()->values();

        // User engagement patterns (filtered by date range)
        $hourlyActivity = collect(range(0, 23))->map(function ($hour) use ($dateFrom) {
            return [
                'hour' => $hour,
                'activity' => User::whereNotNull('last_login_at')
                    ->whereRaw('HOUR(last_login_at) = ?', [$hour])
                    ->where('last_login_at', '>=', $dateFrom)
                    ->count()
            ];
        });

        // Counselor performance (filtered by date range)
        $counselorStats = User::where('role', 'counselor')
            ->withCount([
                'counselingSessions as total_sessions' => function($query) use ($dateFrom) {
                    $query->where('created_at', '>=', $dateFrom);
                }, 
                'counselingSessions as completed_sessions' => function($query) use ($dateFrom) {
                    $query->where('status', 'completed')->where('created_at', '>=', $dateFrom);
                }
            ])
            ->with(['counselingSessions' => function($query) use ($dateFrom) {
                $query->whereNotNull('rating')->where('created_at', '>=', $dateFrom);
            }])
            ->get()
            ->map(function($counselor) {
                return [
                    'name' => $counselor->name,
                    'total_sessions' => $counselor->total_sessions ?? 0,
                    'completed_sessions' => $counselor->completed_sessions ?? 0,
                    'avg_rating' => $counselor->counselingSessions->avg('rating') ?? 0,
                    'completion_rate' => ($counselor->total_sessions ?? 0) > 0 ? (($counselor->completed_sessions ?? 0) / ($counselor->total_sessions ?? 0)) * 100 : 0
                ];
            });

        return view('admin.reports.index', compact(
            'stats',
            'monthlyUsers',
            'weeklyActivity',
            'dailyEngagement',
            'monthlyQuizAttempts',
            'contentPerformance',
            'hourlyActivity',
            'riskTrends',
            'counselorStats',
            'days'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'users');

        // Generate CSV export based on type
        $filename = $type . '_report_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($type) {
            $file = fopen('php://output', 'w');

            switch ($type) {
                case 'users':
                    fputcsv($file, ['Name', 'Email', 'Registration Number', 'Role', 'Status', 'Last Login', 'Joined Date']);
                    User::chunk(100, function($users) use ($file) {
                        foreach ($users as $user) {
                            fputcsv($file, [
                                $user->name,
                                $user->email,
                                $user->registration_number,
                                $user->role,
                                $user->is_active ? 'Active' : 'Inactive',
                                $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never',
                                $user->created_at->format('Y-m-d'),
                            ]);
                        }
                    });
                    break;

                case 'assessments':
                    fputcsv($file, ['User', 'Assessment', 'Risk Level', 'Score', 'Date', 'Recommendations']);
                    AssessmentAttempt::with(['user', 'assessment'])->chunk(100, function($attempts) use ($file) {
                        foreach ($attempts as $attempt) {
                            fputcsv($file, [
                                $attempt->user ? $attempt->user->name : 'Anonymous',
                                $attempt->assessment ? $attempt->assessment->title : 'Unknown',
                                $attempt->risk_level,
                                $attempt->score ?? 'N/A',
                                $attempt->created_at->format('Y-m-d H:i:s'),
                                $attempt->recommendations ?? 'None',
                            ]);
                        }
                    });
                    break;

                case 'quiz_attempts':
                    fputcsv($file, ['Student', 'Quiz', 'Score', 'Status', 'Attempts', 'Date']);
                    QuizAttempt::with(['user', 'quiz'])->chunk(100, function($attempts) use ($file) {
                        foreach ($attempts as $attempt) {
                            fputcsv($file, [
                                $attempt->user->name,
                                $attempt->quiz->title,
                                $attempt->score . '%',
                                $attempt->passed ? 'Passed' : 'Failed',
                                $attempt->attempt_number ?? 1,
                                $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s') : 'In Progress',
                            ]);
                        }
                    });
                    break;

                case 'counseling_sessions':
                    fputcsv($file, ['Student', 'Counselor', 'Status', 'Priority', 'Method', 'Duration', 'Rating', 'Date']);
                    CounselingSession::with(['student', 'counselor'])->chunk(100, function($sessions) use ($file) {
                        foreach ($sessions as $session) {
                            $duration = $session->started_at && $session->completed_at 
                                ? $session->started_at->diffInMinutes($session->completed_at) . ' min'
                                : 'N/A';
                            
                            fputcsv($file, [
                                $session->student ? $session->student->name : 'Unknown',
                                $session->counselor ? $session->counselor->name : 'Unassigned',
                                $session->status,
                                $session->priority,
                                $session->preferred_method ?? 'Not specified',
                                $duration,
                                $session->rating ? $session->rating . '/5' : 'Not rated',
                                $session->created_at->format('Y-m-d H:i:s'),
                            ]);
                        }
                    });
                    break;

                case 'content_views':
                    fputcsv($file, ['Content Title', 'Type', 'Views', 'Published', 'Author', 'Created Date']);
                    EducationalContent::with(['author'])->chunk(100, function($contents) use ($file) {
                        foreach ($contents as $content) {
                            fputcsv($file, [
                                $content->title,
                                $content->type,
                                $content->views ?? 0,
                                $content->is_published ? 'Yes' : 'No',
                                $content->author ? $content->author->name : 'Unknown',
                                $content->created_at->format('Y-m-d'),
                            ]);
                        }
                    });
                    break;

                case 'all':
                    // Create a comprehensive report with summary statistics
                    fputcsv($file, ['Report Type', 'Metric', 'Value', 'Generated At']);
                    
                    $stats = [
                        ['Users', 'Total Users', User::count()],
                        ['Users', 'Active Users (30 days)', User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subMonth())->count()],
                        ['Users', 'Counselors', User::where('role', 'counselor')->count()],
                        ['Sessions', 'Total Sessions', CounselingSession::count()],
                        ['Sessions', 'Completed Sessions', CounselingSession::where('status', 'completed')->count()],
                        ['Sessions', 'Active Sessions', CounselingSession::where('status', 'active')->count()],
                        ['Assessments', 'Total Assessments', AssessmentAttempt::count()],
                        ['Assessments', 'High Risk Cases', AssessmentAttempt::where('risk_level', 'high')->count()],
                        ['Content', 'Total Content', EducationalContent::count()],
                        ['Content', 'Published Content', EducationalContent::where('is_published', true)->count()],
                        ['Content', 'Total Views', EducationalContent::sum('views')],
                        ['Quizzes', 'Total Quiz Attempts', QuizAttempt::count()],
                        ['Quizzes', 'Pass Rate (%)', QuizAttempt::where('passed', true)->count() / max(QuizAttempt::count(), 1) * 100],
                    ];

                    foreach ($stats as $stat) {
                        fputcsv($file, [
                            $stat[0],
                            $stat[1],
                            is_numeric($stat[2]) ? number_format($stat[2], 2) : $stat[2],
                            now()->format('Y-m-d H:i:s')
                        ]);
                    }
                    break;

                default:
                    fputcsv($file, ['Error', 'Invalid export type specified']);
                    break;
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}