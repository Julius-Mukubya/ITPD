<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class CheckCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check categories and their images';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $categories = Category::all(['name', 'image', 'is_active']);
        
        $this->info('Categories and their images:');
        foreach ($categories as $category) {
            $active = $category->is_active ? 'Active' : 'Inactive';
            $this->line("- {$category->name}: " . ($category->image ?: 'No image') . " ({$active})");
        }
        
        return 0;
    }
}
