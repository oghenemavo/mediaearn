<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Video Earning',
                'slug' => 'video_earning',
                'description' => 'Earning per video',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '20.09',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Minimum Payout',
                'slug' => 'min_payout',
                'description' => 'Minimum Payout',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '100.50',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Referral Bonus Type',
                'slug' => 'referral_bonus_type',
                'description' => 'Percentage or Fixed Value Bonus Type',
                'meta' => json_encode([
                    'type' => 'select',
                    'options' => [
                        'percentage' => 'Percentage %',
                        'fixed' => 'Fixed Value'
                    ]
                ]),
                'value' => 'percentage',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Referral Bonus',
                'slug' => 'referral_bonus',
                'description' => 'Referral Bonus',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maximum Videos (SUB)',
                'slug' => 'max_videos_sub',
                'description' => 'Maximum Videos a subscribed user can view',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '1',
                    'step' => '1'
                ]),
                'value' => '4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maximum Videos (NOT SUB)',
                'slug' => 'max_videos_non_sub',
                'description' => 'Maximum Videos a non subscribed user can view',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '1',
                    'step' => '1'
                ]),
                'value' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Downline Bonus (%)',
                'slug' => 'downline_bonus',
                'description' => 'Downline Base Bonus (%)',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Downline Sharing Factor',
                'slug' => 'downline_sharing_factor',
                'description' => 'Downline Sharing Factor',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sign up Bonus',
                'slug' => 'signup_bonus',
                'description' => 'Bonus Added to User Wallet when they sign up',
                'meta' => json_encode([
                    'type' => 'number',
                    'min' => '0.01',
                    'step' => '0.01'
                ]),
                'value' => '500',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        AppSetting::upsert($data, 'slug');
    }
}
