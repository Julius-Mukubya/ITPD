<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    DashboardController,
    ContentController,
    CampaignController,
    ProfileController,
    NotificationController,
    PublicAssessmentController,
    PublicCounselingController,
    PublicForumController,
    ContentFlagController
};
use App\Http\Controllers\Auth\{
    LoginController as AuthLoginController,
    RegisterController as AuthRegisterController,
    LogoutController as AuthLogoutController
};
use App\Http\Controllers\Student\{
    AssessmentController as StudentAssessmentController,
    CounselingController as StudentCounselingController,
    ForumController as StudentForumController
};
use App\Http\Controllers\Admin\{
    ContentController as AdminContentController,
    UserController as AdminUserController,
    AssessmentController as AdminAssessmentController,
    CampaignController as AdminCampaignController,

    ReportController as AdminReportController,
    SettingsController as AdminSettingsController
};
use App\Http\Controllers\Counselor\SessionController as CounselorSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('public.about');
})->name('public.about');
Route::get('/contact', function () {
    return view('public.contact');
})->name('public.contact');

// CSRF Token Route
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('csrf.token');

// AJAX Authentication Routes
Route::post('/ajax/login', [AuthLoginController::class, 'ajaxLogin'])->name('ajax.login');
Route::post('/ajax/register', [AuthRegisterController::class, 'ajaxRegister'])->name('ajax.register');

// Regular Authentication Routes
Route::post('/register', [AuthRegisterController::class, 'register'])->name('register');

// Custom logout route with toast message
Route::post('/logout', [AuthLogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Public Content Routes
Route::prefix('content')->name('content.')->group(function () {
    Route::get('/', [ContentController::class, 'index'])->name('index');
    Route::get('/{content}', [ContentController::class, 'show'])->name('show');
    
    // Public review viewing
    Route::get('/{content}/reviews', [\App\Http\Controllers\ContentReviewController::class, 'index'])->name('reviews.index');
    
    // Review routes (requires auth)
    Route::middleware('auth')->group(function () {
        Route::post('/{content}/reviews', [\App\Http\Controllers\ContentReviewController::class, 'store'])->name('reviews.store');
        Route::post('/{content}/quick-feedback', [\App\Http\Controllers\ContentReviewController::class, 'quickFeedback'])->name('quick-feedback');
        Route::put('/reviews/{review}', [\App\Http\Controllers\ContentReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\ContentReviewController::class, 'destroy'])->name('reviews.destroy');
    });
    
    // Bookmark toggle (requires auth)
    Route::middleware('auth')->post('/{content}/bookmark', function(\App\Models\EducationalContent $content) {
        $bookmark = \App\Models\Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_type', \App\Models\EducationalContent::class)
            ->where('bookmarkable_id', $content->id)
            ->first();
        
        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['success' => true, 'bookmarked' => false, 'message' => 'Removed from bookmarks']);
        } else {
            \App\Models\Bookmark::create([
                'user_id' => auth()->id(),
                'bookmarkable_type' => \App\Models\EducationalContent::class,
                'bookmarkable_id' => $content->id,
            ]);
            return response()->json(['success' => true, 'bookmarked' => true, 'message' => 'Added to bookmarks']);
        }
    })->name('bookmark');
});

// Public Campaign Routes
Route::prefix('campaigns')->name('campaigns.')->group(function () {
    Route::get('/', [CampaignController::class, 'index'])->name('index');
    Route::get('/sample/{slug}', [CampaignController::class, 'sample'])->name('sample');
    Route::get('/{campaign}', [CampaignController::class, 'show'])->name('show');
    
    Route::middleware('auth')->group(function () {
        Route::post('/{campaign}/register', [CampaignController::class, 'register'])->name('register');
        Route::delete('/{campaign}/unregister', [CampaignController::class, 'unregister'])->name('unregister');
    });
});

// Public Counseling Routes
Route::prefix('counseling')->name('public.counseling.')->group(function () {
    Route::get('/', [PublicCounselingController::class, 'index'])->name('index');
    Route::get('/counselors', [PublicCounselingController::class, 'counselors'])->name('counselors');
    Route::get('/counselors/{slug}', [PublicCounselingController::class, 'counselor'])->name('counselor');
    
    // Session Management - requires authentication
    Route::middleware('auth')->group(function () {
        Route::get('/my-sessions', [PublicCounselingController::class, 'sessions'])->name('sessions');
        Route::get('/request', [PublicCounselingController::class, 'requestForm'])->name('request');
        Route::post('/request', [PublicCounselingController::class, 'storeRequest'])->name('request.store');
        Route::get('/session/{session}', [PublicCounselingController::class, 'showSession'])->name('session.show');
        Route::post('/session/{session}/message', [PublicCounselingController::class, 'sendMessage'])->name('session.message');
        Route::patch('/session/{session}/end', [PublicCounselingController::class, 'endSession'])->name('session.end');
        Route::post('/session/{session}/follow-up', [PublicCounselingController::class, 'scheduleFollowUp'])->name('session.followup');
        Route::delete('/session/{session}', [PublicCounselingController::class, 'cancelSession'])->name('session.cancel');
        
        // Group session invitation routes (accessible to all authenticated users)
        Route::post('/session/{session}/accept-invitation', [PublicCounselingController::class, 'acceptInvitation'])->name('session.accept-invitation');
        Route::post('/session/{session}/decline-invitation', [PublicCounselingController::class, 'declineInvitation'])->name('session.decline-invitation');
    });
    
    Route::get('/resources', function () {
        return view('public.counseling.resources');
    })->name('resources');
});

// Public Assessment Routes
Route::prefix('assessments')->name('public.assessments.')->group(function () {
    Route::get('/', [PublicAssessmentController::class, 'index'])->name('index');
    Route::get('/{type}', [PublicAssessmentController::class, 'show'])->name('show');
    Route::post('/{type}/result', [PublicAssessmentController::class, 'result'])->name('result');
    Route::get('/{type}/last-result', [PublicAssessmentController::class, 'lastResult'])->name('last-result')->middleware('auth');
});

// Public Forum Routes
Route::prefix('forum')->name('public.forum.')->group(function () {
    Route::get('/', [PublicForumController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [PublicForumController::class, 'category'])->name('category');
    Route::get('/{id}/comments', [PublicForumController::class, 'getComments'])->name('comments');
    Route::get('/test-comments/{id}', function($id) {
        return response()->json(['test' => 'success', 'post_id' => $id]);
    });
    Route::get('/{id}', [PublicForumController::class, 'show'])->name('show');
    
    // Authenticated forum actions
    Route::middleware('auth')->group(function () {
        Route::post('/', [PublicForumController::class, 'store'])->name('store');
        Route::post('/{id}/comment', [PublicForumController::class, 'storeComment'])->name('comment');
        Route::post('/{id}/upvote', [PublicForumController::class, 'upvote'])->name('upvote');
        Route::post('/comment/{commentId}/upvote', [PublicForumController::class, 'upvoteComment'])->name('comment.upvote');
    });
});

// Content Flagging Routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::post('/content-flags', [ContentFlagController::class, 'store'])->name('content-flags.store');
    Route::delete('/content-flags', [ContentFlagController::class, 'destroy'])->name('content-flags.destroy');
    
    // Session Feedback Routes
    Route::post('/sessions/{session}/feedback', [\App\Http\Controllers\SessionFeedbackController::class, 'store'])->name('sessions.feedback.store');
    Route::put('/sessions/{session}/feedback/{feedback}', [\App\Http\Controllers\SessionFeedbackController::class, 'update'])->name('sessions.feedback.update');
    Route::delete('/sessions/{session}/feedback/{feedback}', [\App\Http\Controllers\SessionFeedbackController::class, 'destroy'])->name('sessions.feedback.destroy');
});

// Authenticated Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    
    // Dashboard Route - redirects based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::patch('/video-preferences', [ProfileController::class, 'updateVideoPreferences'])->name('video-preferences.update');
        Route::delete('/avatar', [ProfileController::class, 'removeAvatar'])->name('avatar.remove');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
    
    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/dropdown', [NotificationController::class, 'dropdown'])->name('dropdown');
        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::patch('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/mark-message-read', [NotificationController::class, 'markMessageAsRead'])->name('mark-message-read');
    });
    
    // User Routes
    Route::middleware('role:user')->prefix('student')->name('student.')->group(function () {
        // Users don't have a separate dashboard - they use the public homepage
        
        // Assessment Routes
        Route::prefix('assessments')->name('assessments.')->group(function () {
            Route::get('/', [StudentAssessmentController::class, 'index'])->name('index');
            Route::get('/{assessment}', [StudentAssessmentController::class, 'show'])->name('show');
            Route::post('/', [StudentAssessmentController::class, 'store'])->name('store');
            Route::get('/attempt/{attempt}/result', [StudentAssessmentController::class, 'result'])->name('result');
        });
        
        // Counseling Routes
        Route::prefix('counseling')->name('counseling.')->group(function () {
            Route::get('/', [StudentCounselingController::class, 'index'])->name('index');
            Route::get('/create', [StudentCounselingController::class, 'create'])->name('create');
            Route::post('/', [StudentCounselingController::class, 'store'])->name('store');
            Route::get('/{counseling}', [StudentCounselingController::class, 'show'])->name('show');
            Route::post('/{counseling}/message', [StudentCounselingController::class, 'sendMessage'])->name('message');
            Route::delete('/{counseling}', [StudentCounselingController::class, 'cancel'])->name('cancel');
            
            // Group session invitation routes
            Route::post('/{counseling}/accept-invitation', [StudentCounselingController::class, 'acceptInvitation'])->name('accept-invitation');
            Route::post('/{counseling}/decline-invitation', [StudentCounselingController::class, 'declineInvitation'])->name('decline-invitation');
        });
        
        // Forum Routes
        Route::prefix('forum')->name('forum.')->group(function () {
            Route::get('/', [StudentForumController::class, 'index'])->name('index');
            Route::get('/create', [StudentForumController::class, 'create'])->name('create');
            Route::post('/', [StudentForumController::class, 'store'])->name('store');
            Route::get('/{forum}', [StudentForumController::class, 'show'])->name('show');
            Route::post('/{forum}/comment', [StudentForumController::class, 'storeComment'])->name('comment');
            Route::post('/{forum}/upvote', [StudentForumController::class, 'upvote'])->name('upvote');
            Route::post('/comment/{commentId}/upvote', [StudentForumController::class, 'upvoteComment'])->name('comment.upvote');
        });
        
        // Student Profile Routes
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', function() {
                return view('student.profile.edit');
            })->name('edit');
        });
        
        // Student Campaigns Routes
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', function() {
                // Count campaigns with 'active' status (regardless of dates)
                $activeCampaigns = \App\Models\Campaign::where('status', 'active')->count();
                $myRegistrations = auth()->user()->campaignParticipations()->count();
                $totalParticipants = \App\Models\CampaignParticipant::distinct('user_id')->count();
                
                // Get all campaigns with 'active' status
                $campaigns = \App\Models\Campaign::where('status', 'active')
                    ->withCount('participants')
                    ->latest()
                    ->get();
                    
                // Get campaigns user is registered for
                $registeredCampaigns = auth()->user()->campaigns()
                    ->withCount('participants')
                    ->get();
                    
                // Get upcoming campaigns (start date in future)
                $upcomingCampaigns = \App\Models\Campaign::where('status', 'active')
                    ->where('start_date', '>', now())
                    ->withCount('participants')
                    ->latest()
                    ->get();
                
                return view('student.campaigns.index', compact('activeCampaigns', 'myRegistrations', 'totalParticipants', 'campaigns', 'registeredCampaigns', 'upcomingCampaigns'));
            })->name('index');
        });
        
        // Bookmark toggle
        Route::post('/content/{content}/bookmark', function(\App\Models\EducationalContent $content) {
            $bookmark = \App\Models\Bookmark::where('user_id', auth()->id())
                ->where('bookmarkable_type', \App\Models\EducationalContent::class)
                ->where('bookmarkable_id', $content->id)
                ->first();
            
            if ($bookmark) {
                $bookmark->delete();
                return response()->json(['success' => true, 'bookmarked' => false, 'message' => 'Removed from bookmarks']);
            } else {
                \App\Models\Bookmark::create([
                    'user_id' => auth()->id(),
                    'bookmarkable_type' => \App\Models\EducationalContent::class,
                    'bookmarkable_id' => $content->id,
                ]);
                return response()->json(['success' => true, 'bookmarked' => true, 'message' => 'Added to bookmarks']);
            }
        })->name('content.bookmark');
        
        // Student Content Routes
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/library', function() {
                // Calculate total reading time from viewed content
                $viewedContent = auth()->user()->contentViews()->with('content')->get();
                $totalTime = $viewedContent->sum(function($view) {
                    return $view->content ? $view->content->reading_time : 0;
                });
                
                $stats = [
                    'total_viewed' => auth()->user()->contentViews()->count(),
                    'bookmarked' => auth()->user()->bookmarks()
                        ->where('bookmarkable_type', \App\Models\EducationalContent::class)
                        ->count(),
                    'total_time' => $totalTime,
                    'streak_days' => 0, // Calculate streak
                ];
                
                $continueReading = \App\Models\EducationalContent::published()->latest()->take(3)->get();
                
                // Get bookmarked content
                $bookmarkedContent = \App\Models\EducationalContent::whereHas('bookmarks', function($query) {
                    $query->where('user_id', auth()->id());
                })->latest()->take(10)->get();
                
                $recentlyViewed = auth()->user()->contentViews()->with('content')->latest()->take(10)->get();
                $recommendedContent = \App\Models\EducationalContent::published()->inRandomOrder()->take(6)->get();
                
                return view('student.content.index', compact('stats', 'continueReading', 'bookmarkedContent', 'recentlyViewed', 'recommendedContent'));
            })->name('library');
        });
    });
    
    // Counselor Routes (accessible by counselors and admins)
    Route::middleware(['auth'])->prefix('counselor')->name('counselor.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::prefix('sessions')->name('sessions.')->group(function () {
            Route::get('/', [CounselorSessionController::class, 'index'])->name('index');
            Route::get('/{session}', [CounselorSessionController::class, 'show'])->name('show');
            Route::post('/{session}/accept', [CounselorSessionController::class, 'accept'])->name('accept');
            Route::post('/{session}/complete', [CounselorSessionController::class, 'complete'])->name('complete');
            Route::post('/{session}/message', [CounselorSessionController::class, 'sendMessage'])->name('message');
            Route::post('/{session}/meeting-link', [CounselorSessionController::class, 'updateMeetingLink'])->name('update-meeting-link');
            Route::post('/{session}/remove-meeting-link', [CounselorSessionController::class, 'removeMeetingLink'])->name('remove-meeting-link');

            Route::post('/{session}/notes', [CounselorSessionController::class, 'addNote'])->name('notes.add');
            Route::delete('/{session}/notes/{noteId}', [CounselorSessionController::class, 'deleteNote'])->name('notes.delete');
        });

        // Session Notes Management
        Route::resource('notes', \App\Http\Controllers\Counselor\NoteController::class);

        // Simple counseling features
        Route::get('/clients', [CounselorSessionController::class, 'students'])->name('clients');
        Route::get('/schedule', [CounselorSessionController::class, 'schedule'])->name('schedule');
        Route::get('/reports', [CounselorSessionController::class, 'reports'])->name('reports');
        Route::get('/reports/export', [CounselorSessionController::class, 'exportReports'])->name('reports.export');

        // Contact Information Setup
        Route::get('/contact-setup', [CounselorSessionController::class, 'contactSetup'])->name('contact-setup');
        Route::post('/contact-setup', [CounselorSessionController::class, 'updateContactInfo'])->name('contact-setup.update');
        Route::post('/contact-setup/field', [CounselorSessionController::class, 'updateContactField'])->name('contact-setup.update-field');
        Route::post('/contact-setup/custom', [CounselorSessionController::class, 'addCustomContact'])->name('contact-setup.add-custom');
        Route::post('/contact-setup/custom/update', [CounselorSessionController::class, 'updateCustomContact'])->name('contact-setup.update-custom');
        Route::delete('/contact-setup/custom/{key}', [CounselorSessionController::class, 'deleteCustomContact'])->name('contact-setup.delete-custom');
        Route::post('/contact-setup/meeting', [CounselorSessionController::class, 'addMeetingLink'])->name('contact-setup.add-meeting');
        Route::delete('/contact-setup/meeting/{key}', [CounselorSessionController::class, 'deleteMeetingLink'])->name('contact-setup.delete-meeting');

        // Content Management (Counselors can only manage their own content)
        Route::resource('contents', \App\Http\Controllers\Counselor\ContentController::class);

        // Campaign Management (Counselors can only manage their own campaigns)
        Route::resource('campaigns', \App\Http\Controllers\Counselor\CampaignController::class);
        
        // Forum Moderation
        Route::prefix('forum')->name('forum.')->group(function () {
            Route::get('/', function() {
                $totalPosts = \App\Models\ForumPost::count();
                $todayPosts = \App\Models\ForumPost::whereDate('created_at', today())->count();
                $flaggedPosts = 0; // Implement flagging system
                $totalComments = \App\Models\ForumComment::count();
                $posts = \App\Models\ForumPost::with(['user', 'category'])->withCount('comments')->latest()->paginate(20);
                
                return view('counselor.forum.index', compact('totalPosts', 'todayPosts', 'flaggedPosts', 'totalComments', 'posts'));
            })->name('index');
        });
        
        // Counselor Profile
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/edit', function() {
                return view('counselor.profile.edit');
            })->name('edit');
        });
    });
    
    // Shared Routes (Admin & Counselor access)
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        // Content Management (Counselors can create/edit resources)
        Route::resource('contents', AdminContentController::class);
        
        // Campaign Management (Counselors can create/manage campaigns)
        Route::resource('campaigns', AdminCampaignController::class);
    });
    
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Search functionality
        Route::get('/search', [\App\Http\Controllers\Admin\SearchController::class, 'search'])->name('search');
        Route::get('/search/suggestions', [\App\Http\Controllers\Admin\SearchController::class, 'suggestions'])->name('search.suggestions');
        
        // User Management (Admin only)
        Route::resource('users', AdminUserController::class);
        
        // Assessment Management (Admin only)
        Route::resource('assessments', AdminAssessmentController::class)->except(['show']);
        Route::get('assessments/{assessment}/details', [AdminAssessmentController::class, 'show'])->name('assessments.show');
        

        
        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminReportController::class, 'index'])->name('index');
            Route::get('/export', [AdminReportController::class, 'export'])->name('export');
        });
        
        // Counseling Management
        Route::prefix('counseling')->name('counseling.')->group(function () {
            Route::get('/', [AdminSettingsController::class, 'counselingIndex'])->name('index');
            Route::get('/reports/analytics', [AdminSettingsController::class, 'counselingAnalytics'])->name('reports.analytics');
        });
        
        // Counselor Management
        Route::prefix('counselors')->name('counselors.')->group(function () {
            Route::get('/create', function () {
                return view('admin.counselors.create');
            })->name('create');
            Route::get('/reports/export', [AdminSettingsController::class, 'counselingExport'])->name('reports.export');
        });
        
        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [AdminSettingsController::class, 'index'])->name('index');
            Route::patch('/update', [AdminSettingsController::class, 'update'])->name('update');
            Route::patch('/email/update', [AdminSettingsController::class, 'updateEmail'])->name('email.update');
            Route::patch('/security/update', [AdminSettingsController::class, 'updateSecurity'])->name('security.update');
            Route::patch('/content/update', [AdminSettingsController::class, 'updateContent'])->name('content.update');
        });

        // Content Flags Management
        Route::prefix('content-flags')->name('content-flags.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ContentFlagController::class, 'index'])->name('index');
            Route::get('/{flag}', [\App\Http\Controllers\Admin\ContentFlagController::class, 'show'])->name('show');
            Route::put('/{flag}', [\App\Http\Controllers\Admin\ContentFlagController::class, 'update'])->name('update');
            Route::post('/bulk-update', [\App\Http\Controllers\Admin\ContentFlagController::class, 'bulkUpdate'])->name('bulk-update');
        });
    });
});
