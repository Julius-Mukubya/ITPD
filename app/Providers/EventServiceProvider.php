<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Models\Campaign;
use App\Models\CounselingSession;
use App\Models\EducationalContent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // User registration notifications
        User::created(function ($user) {
            app(\App\Http\Controllers\NotificationController::class)->createSystemNotification(
                'user_registered',
                'New User Registered',
                $user->name . ' has joined the platform',
                route('admin.users.show', $user->id)
            );
        });

        // Campaign creation notifications
        Campaign::created(function ($campaign) {
            app(\App\Http\Controllers\NotificationController::class)->createSystemNotification(
                'campaign_created',
                'New Campaign Created',
                'Campaign "' . $campaign->title . '" has been created',
                route('admin.campaigns.show', $campaign->id)
            );
        });

        // Counseling session notifications
        CounselingSession::created(function ($session) {
            app(\App\Http\Controllers\NotificationController::class)->createSystemNotification(
                'counseling_session',
                'New Counseling Session',
                'A new counseling session has been requested: ' . $session->subject,
                route('admin.counseling.index')
            );
        });

        CounselingSession::updated(function ($session) {
            if ($session->isDirty('status')) {
                app(\App\Http\Controllers\NotificationController::class)->createSystemNotification(
                    'counseling_session',
                    'Counseling Session Updated',
                    'Session "' . $session->subject . '" status changed to ' . $session->status,
                    route('admin.counseling.index')
                );
            }
        });

        // Educational content notifications
        EducationalContent::created(function ($content) {
            app(\App\Http\Controllers\NotificationController::class)->createSystemNotification(
                'content_created',
                'New Content Published',
                'New educational content: "' . $content->title . '"',
                route('content.show', $content->id)
            );
        });
    }
}
