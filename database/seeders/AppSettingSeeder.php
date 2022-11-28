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
        ];
        AppSetting::upsert($data, 'slug');
    }
}
