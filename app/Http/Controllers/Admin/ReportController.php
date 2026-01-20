<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, EducationalContent, Quiz, QuizAttempt, AssessmentAttempt, CounselingSession};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
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

            // Content statistics
            'total_contents' => EducationalContent::count(),
            'published_contents' => EducationalContent::where('is_published', true)->count(),
            'total_views' => EducationalContent::sum('views'),
            'avg_views' => EducationalContent::avg('views'),
            'most_viewed_content' => EducationalContent::orderBy('views', 'desc')->first(),
            'content_engagement_rate' => EducationalContent::where('views', '>', 0)->count() / max(EducationalContent::count(), 1) * 100,

            // Quiz statistics
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'total_quiz_attempts' => QuizAttempt::count(),
            'completed_attempts' => QuizAttempt::whereNotNull('completed_at')->count(),
            'avg_quiz_score' => QuizAttempt::whereNotNull('score')->avg('score'),
            'pass_rate' => QuizAttempt::where('passed', true)->count() / max(QuizAttempt::count(), 1) * 100,
            'quiz_completion_rate' => QuizAttempt::whereNotNull('completed_at')->count() / max(QuizAttempt::count(), 1) * 100,

            // Assessment statistics
            'total_assessments' => AssessmentAttempt::count(),
            'low_risk_count' => AssessmentAttempt::where('risk_level', 'low')->count(),
            'medium_risk_count' => AssessmentAttempt::where('risk_level', 'medium')->count(),
            'high_risk_count' => AssessmentAttempt::where('risk_level', 'high')->count(),
            'assessments_this_week' => AssessmentAttempt::where('created_at', '>=', now()->subWeek())->count(),

            // Counseling statistics
            'total_sessions' => CounselingSession::count(),
            'pending_sessions' => CounselingSession::where('status', 'pending')->count(),
            'active_sessions' => CounselingSession::where('status', 'active')->count(),
            'completed_sessions' => CounselingSession::where('status', 'completed')->count(),
            'avg_session_duration' => CounselingSession::whereNotNull('started_at')
                ->whereNotNull('completed_at')
                ->get()
                ->map(function($session) {
                    return $session->started_at && $session->completed_at 
                        ? $session->started_at->diffInMinutes($session->completed_at) 
                        : 0;
                })
                ->avg() ?? 0,
            'session_satisfaction' => CounselingSession::whereNotNull('rating')->avg('rating') ?? 0,
        ];

        // Enhanced time-based analytics
        $monthlyUsers = User::where('created_at', '>=', now()->subMonths(12))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $weeklyActivity = User::whereNotNull('last_login_at')->where('last_login_at', '>=', now()->subWeeks(8))
            ->select(DB::raw('WEEK(last_login_at) as week'), DB::raw('count(*) as count'))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        $dailyEngagement = collect(range(0, 6))->map(function ($i) {
            $date = now()->subDays($i);
            return [
                'date' => $date->format('M d'),
                'users' => User::whereNotNull('last_login_at')->whereDate('last_login_at', $date)->count(),
                'sessions' => CounselingSession::whereDate('created_at', $date)->count(),
                'assessments' => AssessmentAttempt::whereDate('created_at', $date)->count(),
            ];
        })->reverse()->values();

        $monthlyQuizAttempts = QuizAttempt::where('created_at', '>=', now()->subMonths(6))
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('count(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Content performance analytics
        $contentPerformance = EducationalContent::select('title', 'views', 'created_at')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        // Remove category stats since category column doesn't exist
        $categoryStats = collect();

        // User engagement patterns
        $hourlyActivity = collect(range(0, 23))->map(function ($hour) {
            return [
                'hour' => $hour,
                'activity' => User::whereNotNull('last_login_at')
                    ->whereRaw('HOUR(last_login_at) = ?', [$hour])
                    ->where('last_login_at', '>=', now()->subWeek())
                    ->count()
            ];
        });

        // Risk assessment trends
        $riskTrends = collect(range(0, 6))->map(function ($i) {
            $date = now()->subDays($i);
            return [
                'date' => $date->format('M d'),
                'low' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'low')->count(),
                'medium' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'medium')->count(),
                'high' => AssessmentAttempt::whereDate('created_at', $date)->where('risk_level', 'high')->count(),
            ];
        })->reverse()->values();

        // Counselor performance
        $counselorStats = User::where('role', 'counselor')
            ->withCount(['counselingSessions as total_sessions', 'counselingSessions as completed_sessions' => function($query) {
                $query->where('status', 'completed');
            }])
            ->with(['counselingSessions' => function($query) {
                $query->whereNotNull('rating');
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
            'categoryStats',
            'hourlyActivity',
            'riskTrends',
            'counselorStats'
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
                    fputcsv($file, ['Name', 'Email', 'Registration Number', 'Role', 'Status', 'Joined Date']);
                    User::chunk(100, function($users) use ($file) {
                        foreach ($users as $user) {
                            fputcsv($file, [
                                $user->name,
                                $user->email,
                                $user->registration_number,
                                $user->role,
                                $user->is_active ? 'Active' : 'Inactive',
                                $user->created_at->format('Y-m-d'),
                            ]);
                        }
                    });
                    break;

                case 'quiz_attempts':
                    fputcsv($file, ['Student', 'Quiz', 'Score', 'Status', 'Date']);
                    QuizAttempt::with(['user', 'quiz'])->chunk(100, function($attempts) use ($file) {
                        foreach ($attempts as $attempt) {
                            fputcsv($file, [
                                $attempt->user->name,
                                $attempt->quiz->title,
                                $attempt->score . '%',
                                $attempt->passed ? 'Passed' : 'Failed',
                                $attempt->completed_at ? $attempt->completed_at->format('Y-m-d') : 'N/A',
                            ]);
                        }
                    });
                    break;

                case 'counseling_sessions':
                    fputcsv($file, ['Student', 'Counselor', 'Status', 'Priority', 'Date']);
                    CounselingSession::with(['student', 'counselor'])->chunk(100, function($sessions) use ($file) {
                        foreach ($sessions as $session) {
                            fputcsv($file, [
                                $session->student ? $session->student->name : 'Unknown',
                                $session->counselor ? $session->counselor->name : 'Unassigned',
                                $session->status,
                                $session->priority,
                                $session->created_at->format('Y-m-d'),
                            ]);
                        }
                    });
                    break;
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}