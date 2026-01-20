<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearNonUserData extends Command
{
    protected $signature = 'data:clear-non-users {--force : Force the operation without confirmation}';
    protected $description = 'Clear all seeded data except users';

    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('This will delete all data except users. Are you sure?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info('Clearing non-user data...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Tables to clear (excluding users and related auth tables)
        $tablesToClear = [
            'activity_logs',
            'assessment_attempts',
            'assessment_questions',
            'assessment_responses',
            'assessments',
            'bookmarks',
            'campaign_participants',
            'campaigns',
            'categories',
            'content_views',
            'counseling_messages',
            'counseling_sessions',
            'educational_contents',
            'emergency_contacts',
            'feedback',
            'forum_categories',
            'forum_comments',
            'forum_posts',
            'forum_upvotes',
            'notifications',
            'quiz_answers',
            'quiz_attempts',
            'quiz_options',
            'quiz_questions',
            'quizzes',
        ];

        foreach ($tablesToClear as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->line("✓ Cleared: {$table}");
            } else {
                $this->warn("⚠ Table not found: {$table}");
            }
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('');
        $this->info('✓ All non-user data has been cleared successfully!');
        $this->info('Users, roles, and authentication data remain intact.');

        return 0;
    }
}
