<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check current notifications in the system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $notifications = \DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if ($notifications->isEmpty()) {
            $this->info('No notifications found in the system.');
            return 0;
        }

        $this->info('Recent notifications:');
        $this->line('');

        foreach ($notifications as $notification) {
            $this->line("ID: {$notification->id}");
            $this->line("Type: {$notification->type}");
            $this->line("Title: {$notification->title}");
            $this->line("Message: {$notification->message}");
            $this->line("User ID: {$notification->user_id}");
            $this->line("Read: " . ($notification->is_read ? 'Yes' : 'No'));
            $this->line("Created: {$notification->created_at}");
            $this->line('---');
        }

        $totalCount = \DB::table('notifications')->count();
        $unreadCount = \DB::table('notifications')->where('is_read', false)->count();

        $this->info("Total notifications: {$totalCount}");
        $this->info("Unread notifications: {$unreadCount}");

        return 0;
    }
}