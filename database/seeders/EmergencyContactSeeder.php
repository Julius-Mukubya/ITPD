<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmergencyContact;

class EmergencyContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            ['name' => 'National Drug Authority Uganda', 'organization' => 'NDA Uganda', 'phone' => '+256417677000', 'email' => 'info@nda.or.ug', 'type' => 'other', 'is_24_7' => false, 'order' => 1],
            ['name' => 'Mental Health Uganda Helpline', 'organization' => 'Mental Health Uganda', 'phone' => '+256800100066', 'email' => 'info@mentalhealthuganda.org', 'type' => 'hotline', 'is_24_7' => true, 'order' => 2],
            ['name' => 'Butabika National Referral Hospital', 'organization' => 'Ministry of Health Uganda', 'phone' => '+256414289209', 'type' => 'hospital', 'is_24_7' => true, 'order' => 3],
            ['name' => 'Uganda Police Emergency', 'organization' => 'Uganda Police Force', 'phone' => '999', 'type' => 'police', 'is_24_7' => true, 'order' => 4],
            ['name' => 'WellPath Student Counseling Center', 'organization' => 'WellPath', 'phone' => '+256414259722', 'email' => 'counseling@wellpath.org', 'type' => 'counseling', 'is_24_7' => false, 'order' => 5],
        ];

        foreach ($contacts as $contact) {
            EmergencyContact::firstOrCreate(
                ['phone' => $contact['phone']],
                $contact
            );
        }
    }
}