<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Campaign;
use App\Models\CampaignContact;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing contact information from campaigns table to campaign_contacts table
        $campaigns = Campaign::whereNotNull('contact_email')->get();
        
        foreach ($campaigns as $campaign) {
            CampaignContact::create([
                'campaign_id' => $campaign->id,
                'name' => 'Campaign Coordinator', // Default name
                'title' => null,
                'email' => $campaign->contact_email,
                'phone' => $campaign->contact_phone,
                'office_location' => $campaign->contact_office,
                'office_hours' => $campaign->contact_hours,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all campaign contacts
        CampaignContact::truncate();
    }
};