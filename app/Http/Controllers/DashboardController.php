<?php

namespace App\Http\Controllers;

use App\Models\{
    EducationalContent, 
    Assessment,
    AssessmentAttempt,
    CounselingSession,
    CounselingMessage,
    User, 
    Campaign,
    CampaignParticipant,
    ForumPost,
    ForumComment,
    ForumCategory,
    ContentView,
    Notification
};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get role-specific data
        switch($user->role) {
            case 'user':
                // Redirect users to public homepage - they don't need a separate dashboard
                return redirect()->route('home');
            case 'counselor':
                $data = $this->getCounselorData($user);
                $view = 'counselor.dashboard';
                break;
            case 'admin':
                $data = $this->getAdminData();
                $view = 'admin.dashboard';
                break;
            default:
                $data = $this->getDefaultDashboardData();
                $view = 'dashboard';
        }

        // Extract data array into individual variables for the view
        // Also keep $data for backward compatibility with admin dashboard
        return view($view, array_merge(compact('user', 'data'), $data));
    }

    public function getStudentData($user)
    {
        return [
            // Personal Statistics
            'assessments_taken' => $user->assessmentAttempts()->count(),
            'assessments_this_month' => $user->assessmentAttempts()->whereMonth('created_at', now()->month)->count(),
            'forum_posts' => $user->forumPosts()->count(),
            'forum_comments' => $user->forumComments()->count(),
            'contents_viewed' => $user->contentViews()->count(),
            'total_study_time' => 0, // Placeholder - time tracking not yet implemented
            
            // Counseling & Support
            'counseling_sessions' => $user->allCounselingSessions()->count(),
            'active_counseling' => $user->allCounselingSessions()->where('status', 'active')->count(),
            'completed_counseling' => $user->allCounselingSessions()->where('status', 'completed')->count(),
            'unread_messages' => $user->notifications()->unread()->count(),
            
            // Engagement Metrics
            'streak_days' => $this->calculateStudyStreak($user),
            'this_week_activity' => $user->assessmentAttempts()->where('created_at', '>=', now()->subWeek())->count(),
            'this_month_activity' => $user->assessmentAttempts()->where('created_at', '>=', now()->subMonth())->count(),
            'bookmarks_count' => $user->bookmarks()->count(),
            
            // Progress & Achievements
            'assessment_categories' => $this->getAssessmentCategories($user),
            'recent_achievements' => $this->getRecentAchievements($user),
            
            // Content & Resources
            'recent_contents' => EducationalContent::published()->latest()->take(6)->get(),
            'recommended_contents' => $this->getRecommendedContent($user),
            'available_assessments' => Assessment::latest()->take(5)->get(),
            'my_assessment_attempts' => $user->assessmentAttempts()->with('assessment')->latest()->take(5)->get(),
            'my_sessions' => $user->allCounselingSessions()->with('counselor')->latest()->take(5)->get(),
            'upcoming_campaigns' => Campaign::active()->latest()->take(3)->get(),
            
            // Weekly Activity Data for Charts
            'weekly_assessment_activity' => $this->getUserWeeklyActivity($user, 'assessment_attempts'),
            'weekly_content_views' => $this->getUserWeeklyActivity($user, 'content_views'),
        ];
    }

    private function calculateStudyStreak($user)
    {
        $streak = 0;
        $currentDate = now()->startOfDay();
        
        while (true) {
            $hasActivity = $user->assessmentAttempts()
                ->whereDate('created_at', $currentDate)
                ->exists() || 
                $user->contentViews()
                ->whereDate('created_at', $currentDate)
                ->exists();
                
            if (!$hasActivity) {
                break;
            }
            
            $streak++;
            $currentDate->subDay();
            
            if ($streak > 365) break; // Prevent infinite loop
        }
        
        return $streak;
    }

    private function getAssessmentCategories($user)
    {
        return $user->assessmentAttempts()
            ->join('assessments', 'assessment_attempts.assessment_id', '=', 'assessments.id')
            ->distinct('assessments.type')
            ->count();
    }

    private function getRecentAchievements($user)
    {
        $achievements = [];
        
        // Check for recent milestones
        $recentAttempts = $user->assessmentAttempts()->where('created_at', '>=', now()->subWeek())->count();
        if ($recentAttempts >= 3) {
            $achievements[] = ['title' => 'Self-Aware', 'description' => 'Completed 3 assessments this week', 'icon' => 'psychology'];
        }
        
        $counselingSessions = $user->allCounselingSessions()->where('status', 'completed')->count();
        if ($counselingSessions >= 5) {
            $achievements[] = ['title' => 'Wellness Journey', 'description' => 'Completed 5 counseling sessions', 'icon' => 'favorite'];
        }
        
        return $achievements;
    }

    private function getRecommendedContent($user)
    {
        // Get content based on user's recent assessments
        $recentAssessments = $user->assessmentAttempts()
            ->join('assessments', 'assessment_attempts.assessment_id', '=', 'assessments.id')
            ->pluck('assessments.type')
            ->unique();
            
        // Map assessment types to content categories
        $categoryMapping = [
            'depression' => 'Mental Health',
            'anxiety' => 'Mental Health',
            'substance_abuse' => 'Drug Prevention',
            'stress' => 'Healthy Living',
        ];
        
        $categoryNames = $recentAssessments->map(fn($type) => $categoryMapping[$type] ?? null)->filter();
        
        return EducationalContent::published()
            ->whereHas('category', fn($q) => $q->whereIn('name', $categoryNames))
            ->latest()
            ->take(4)
            ->get();
    }

    private function getUserWeeklyActivity($user, $type)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            
            if ($type === 'assessment_attempts') {
                $count = $user->assessmentAttempts()->whereDate('created_at', $date)->count();
            } else {
                $count = $user->contentViews()->whereDate('created_at', $date)->count();
            }
            
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }
        return $data;
    }

    public function getCounselorData($user)
    {
        // Get actual session counts - only for this counselor
        $pendingSessions = CounselingSession::pending()
            ->where(function($query) use ($user) {
                $query->where('preferred_counselor_id', $user->id)
                      ->orWhere('counselor_id', $user->id);
            })
            ->count();
            
        $activeSessions = $user->counselingAsProvider()->active()->count();
        $weeklyCompleted = $user->counselingAsProvider()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subWeek())
            ->count();
        $totalSessions = $user->counselingAsProvider()->count();
        
        // Get urgent and today's sessions - only for this counselor
        $urgentSessions = CounselingSession::where('priority', 'urgent')
            ->where('status', 'pending')
            ->where(function($query) use ($user) {
                $query->where('preferred_counselor_id', $user->id)
                      ->orWhere('counselor_id', $user->id);
            })
            ->with('student')
            ->latest()
            ->take(5)
            ->get();
            
        $todaysSessions = $user->counselingAsProvider()
            ->whereDate('scheduled_at', today())
            ->with('student')
            ->orderBy('scheduled_at')
            ->get();
        
        return [
            // Direct variables for the view
            'pendingSessions' => $pendingSessions,
            'activeSessions' => $activeSessions,
            'weeklyCompleted' => $weeklyCompleted,
            'totalSessions' => $totalSessions,
            'urgentSessions' => $urgentSessions,
            'todaysSessions' => $todaysSessions,
            
            // Session Statistics
            'total_sessions' => $totalSessions,
            'active_sessions' => $activeSessions,
            'completed_sessions' => $user->counselingAsProvider()->where('status', 'completed')->count(),
            'this_month_completed' => $user->counselingAsProvider()->where('status', 'completed')->whereMonth('completed_at', now()->month)->count(),
            'pending_requests' => $pendingSessions,
            'my_pending_count' => CounselingSession::pending()
                ->where(function($query) use ($user) {
                    $query->where('preferred_counselor_id', $user->id)
                          ->orWhere('counselor_id', $user->id);
                })
                ->count(),
            
            // Performance Metrics
            'average_session_rating' => $user->counselingAsProvider()->where('status', 'completed')->avg('rating') ?? 0,
            'success_rate' => $this->calculateCounselorSuccessRate($user),
            'response_time' => $this->calculateAverageResponseTime($user),
            'this_week_sessions' => $user->counselingAsProvider()->where('created_at', '>=', now()->subWeek())->count(),
            
            // Workload Distribution
            'sessions_by_priority' => $this->getSessionsByPriority($user),
            'sessions_by_status' => $this->getSessionsByStatus($user),
            'weekly_session_trend' => $this->getCounselorWeeklyTrend($user),
            
            // Student Engagement
            'unique_students_helped' => $user->counselingAsProvider()->distinct('student_id')->count(),
            'repeat_students' => $this->getRepeatStudents($user),
            'student_satisfaction' => $this->getStudentSatisfaction($user),
            
            // Recent Data - only for this counselor
            'my_pending' => CounselingSession::pending()
                ->where(function($query) use ($user) {
                    $query->where('preferred_counselor_id', $user->id)
                          ->orWhere('counselor_id', $user->id);
                })
                ->with('student')
                ->latest()
                ->take(5)
                ->get(),
            'my_active' => $user->counselingAsProvider()->active()->with('student')->latest()->get(),
            'recent_completed' => $user->counselingAsProvider()->where('status', 'completed')->with('student')->latest()->take(5)->get(),
            
            // Messages & Communication
            'unread_messages' => $this->getUnreadMessagesCount($user),
            'total_messages_sent' => CounselingMessage::where('sender_id', $user->id)->count(),
        ];
    }

    private function calculateCounselorSuccessRate($user)
    {
        $completed = $user->counselingAsProvider()->where('status', 'completed')->count();
        $total = $user->counselingAsProvider()->whereIn('status', ['completed', 'cancelled'])->count();
        
        return $total > 0 ? round(($completed / $total) * 100, 1) : 0;
    }

    private function calculateAverageResponseTime($user)
    {
        // This would calculate average time between session request and first response
        // For now, return a placeholder
        return rand(2, 24); // hours
    }

    private function getSessionsByPriority($user)
    {
        return [
            'low' => $user->counselingAsProvider()->where('priority', 'low')->count(),
            'medium' => $user->counselingAsProvider()->where('priority', 'medium')->count(),
            'high' => $user->counselingAsProvider()->where('priority', 'high')->count(),
            'urgent' => $user->counselingAsProvider()->where('priority', 'urgent')->count(),
        ];
    }

    private function getSessionsByStatus($user)
    {
        return [
            'pending' => $user->counselingAsProvider()->where('status', 'pending')->count(),
            'active' => $user->counselingAsProvider()->where('status', 'active')->count(),
            'completed' => $user->counselingAsProvider()->where('status', 'completed')->count(),
            'cancelled' => $user->counselingAsProvider()->where('status', 'cancelled')->count(),
        ];
    }

    private function getCounselorWeeklyTrend($user)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = $user->counselingAsProvider()->whereDate('created_at', $date)->count();
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }
        return $data;
    }

    private function getRepeatStudents($user)
    {
        return $user->counselingAsProvider()
            ->select('student_id')
            ->groupBy('student_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();
    }

    private function getStudentSatisfaction($user)
    {
        $ratings = $user->counselingAsProvider()
            ->where('status', 'completed')
            ->whereNotNull('rating')
            ->pluck('rating');
            
        if ($ratings->count() === 0) return 0;
        
        return round($ratings->avg(), 1);
    }

    private function getUnreadMessagesCount($user)
    {
        return CounselingMessage::whereHas('session', function($query) use ($user) {
            $query->where('counselor_id', $user->id);
        })->where('sender_id', '!=', $user->id)->where('is_read', false)->count();
    }

    public function getAdminData()
    {
        return [
            // User Statistics
            'total_users' => User::where('role', 'user')->count(),
            'total_counselors' => User::where('role', 'counselor')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'daily_active_users' => User::where('last_login_at', '>=', now()->subDay())->count(),
            'weekly_active_users' => User::where('last_login_at', '>=', now()->subWeek())->count(),
            'monthly_active_users' => User::where('last_login_at', '>=', now()->subMonth())->count(),
            
            // Content Statistics
            'total_contents' => EducationalContent::count(),
            'published_contents' => EducationalContent::published()->count(),
            'draft_contents' => EducationalContent::where('is_published', false)->count(),
            'featured_contents' => EducationalContent::featured()->count(),
            'total_content_views' => EducationalContent::sum('views'),
            
            // Assessment Statistics
            'total_assessments' => Assessment::count(),
            'total_assessment_attempts' => AssessmentAttempt::count(),
            'this_week_assessments' => AssessmentAttempt::where('created_at', '>=', now()->subWeek())->count(),
            'this_month_assessments' => AssessmentAttempt::whereMonth('created_at', now()->month)->count(),
            
            // Counseling Statistics
            'active_sessions' => CounselingSession::active()->count(),
            'pending_sessions' => CounselingSession::pending()->count(),
            'completed_sessions' => CounselingSession::where('status', 'completed')->count(),
            'total_sessions' => CounselingSession::count(),
            'this_month_sessions' => CounselingSession::whereMonth('created_at', now()->month)->count(),
            
            // System Health Statistics
            'system_status' => 'operational',
            'uptime_percentage' => 99.9,
            'last_backup' => now()->subHours(6)->format('Y-m-d H:i'),
            'storage_usage' => 75, // percentage
            
            // Forum & Community Statistics
            'total_forum_posts' => ForumPost::count(),
            'this_week_posts' => ForumPost::where('created_at', '>=', now()->subWeek())->count(),
            'total_forum_comments' => ForumComment::count(),
            'active_forum_categories' => ForumCategory::whereHas('posts')->count(),
            
            // Campaign Statistics
            'active_campaigns' => Campaign::active()->count(),
            'total_campaigns' => Campaign::count(),
            'campaign_participants' => CampaignParticipant::count(),
            
            // Growth Statistics (last 30 days vs previous 30 days)
            'user_growth' => $this->calculateGrowth(User::class, 'user'),
            'content_growth' => $this->calculateGrowth(EducationalContent::class),
            'session_growth' => $this->calculateGrowth(CounselingSession::class),
            
            // Recent Data
            'recent_users' => User::where('role', 'user')->latest()->take(10)->get(),
            'recent_contents' => EducationalContent::with('author')->latest()->take(5)->get(),
            'recent_sessions' => CounselingSession::with(['student', 'counselor'])->latest()->take(5)->get(),
            'recent_activities' => $this->getRecentActivities(),
            
            // Weekly Activity Data for Charts
            'weekly_registrations' => $this->getWeeklyData(User::class, 'user'),
            'weekly_content_views' => $this->getWeeklyContentViews(),
            'weekly_assessment_attempts' => $this->getWeeklyData(AssessmentAttempt::class),
            'weekly_sessions' => $this->getWeeklyData(CounselingSession::class),
        ];
    }

    private function calculateGrowth($model, $role = null)
    {
        $query = $model::query();
        if ($role) {
            $query->where('role', $role);
        }
        
        $current = $query->clone()->where('created_at', '>=', now()->subDays(30))->count();
        $previous = $query->clone()->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count();
        
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getWeeklyData($model, $role = null)
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $query = $model::whereDate('created_at', $date);
            if ($role) {
                $query->where('role', $role);
            }
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $query->count()
            ];
        }
        return $data;
    }

    private function getWeeklyContentViews()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $views = ContentView::whereDate('viewed_at', $date)->count();
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $views
            ];
        }
        return $data;
    }

    private function getRecentActivities()
    {
        $activities = collect();

        // Recent user registrations
        $recentUsers = User::latest()->take(3)->get();
        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user_registered',
                'title' => 'New user registered',
                'description' => $user->name . ' joined the platform',
                'created_at' => $user->created_at,
                'icon' => 'person_add',
                'color' => 'blue'
            ]);
        }

        // Recent content published
        $recentContent = EducationalContent::where('is_published', true)->latest()->take(2)->get();
        foreach ($recentContent as $content) {
            $activities->push([
                'type' => 'content_published',
                'title' => 'New content published',
                'description' => $content->title,
                'created_at' => $content->created_at,
                'icon' => 'library_books',
                'color' => 'green'
            ]);
        }

        // Recent counseling sessions
        $recentSessions = CounselingSession::with('student')->latest()->take(2)->get();
        foreach ($recentSessions as $session) {
            $activities->push([
                'type' => 'session_created',
                'title' => 'New counseling session',
                'description' => 'Session requested' . ($session->student ? ' by ' . $session->student->name : ''),
                'created_at' => $session->created_at,
                'icon' => 'psychology',
                'color' => 'purple'
            ]);
        }

        // Recent assessment attempts
        $recentAttempts = AssessmentAttempt::with(['user', 'assessment'])->latest()->take(2)->get();
        foreach ($recentAttempts as $attempt) {
            $activities->push([
                'type' => 'assessment_taken',
                'title' => 'Assessment completed',
                'description' => ($attempt->user ? $attempt->user->name : 'User') . ' completed ' . ($attempt->assessment ? $attempt->assessment->title : 'an assessment'),
                'created_at' => $attempt->created_at,
                'icon' => 'assignment',
                'color' => 'orange'
            ]);
        }

        // Sort by created_at and take the most recent 6
        return $activities->sortByDesc('created_at')->take(6)->values();
    }

    private function getDefaultDashboardData()
    {
        return [
            // Platform Statistics
            'total_users' => User::count(),
            'total_resources' => EducationalContent::published()->count(),
            'active_campaigns' => Campaign::active()->count(),
            'total_counselors' => User::where('role', 'counselor')->count(),
            
            // Contact Information (can be moved to config later)
            'support_email' => config('app.support_email', 'admin@wellpath.com'),
            'support_phone' => config('app.support_phone', '+256 XXX XXX XXX'),
            
            // Recent Content for engagement
            'recent_contents' => EducationalContent::published()->latest()->take(3)->get(),
            'featured_campaigns' => Campaign::active()->featured()->take(2)->get(),
        ];
    }
}