<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$campaign = App\Models\Campaign::where('is_featured', true)->first();

if ($campaign) {
    echo "Updating campaign: {$campaign->title}\n";
    echo "Old end date: {$campaign->end_date}\n";
    
    // Set end date to 30 days from now
    $campaign->end_date = now()->addDays(30);
    $campaign->save();
    
    echo "New end date: {$campaign->end_date}\n";
    echo "\nCampaign updated successfully!\n";
} else {
    echo "No featured campaign found\n";
}
