<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestUserCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:user-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user to trigger notification system';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Create a test user to trigger the notification system
        $user = User::create([
            'name' => 'Test User ' . now()->format('H:i:s'),
            'email' => 'test' . time() . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_active' => true,
        ]);

        $this->info('Test user created: ' . $user->name);
        $this->info('This should have triggered a system notification.');
        $this->info('Check /notifications to see it.');

        return 0;
    }
}