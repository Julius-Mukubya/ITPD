<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationController;

class TestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate test system notifications';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notificationController = app(NotificationController::class);

        // Create some test notifications
        $notificationController->createSystemNotification(
            'user_registered',
            'Test User Registration',
            'A test user has registered to demonstrate the notification system',
            route('admin.users.index')
        );

        $notificationController->createSystemNotification(
            'campaign_created',
            'Test Campaign Created',
            'A test campaign has been created to demonstrate notifications',
            route('admin.campaigns.index')
        );

        $notificationController->createSystemNotification(
            'counseling_session',
            'Test Counseling Session',
            'A test counseling session has been created',
            route('admin.counseling.index')
        );

        $notificationController->createSystemNotification(
            'content_created',
            'Test Content Published',
            'Test educational content has been published',
            route('content.index')
        );

        $this->info('Test notifications created successfully!');
        $this->info('Check /notifications to see them.');

        return 0;
    }
}