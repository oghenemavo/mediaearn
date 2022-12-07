<?php

namespace Database\Seeders;

use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
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
                'title' => 'Bronze',
                'price' => '1500.45',
                'description' => 'xyz',
                'meta' => json_encode([
                    'set_discount' => false,
                    'discount' => '0',
                    'label' => false,
                    'max_views' => 3
                ]),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Gold',
                'price' => '5500',
                'description' => 'abc',
                'meta' => json_encode([
                    'set_discount' => false,
                    'discount' => '0',
                    'label' => false,
                    'max_views' => 4
                ]),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Diamond',
                'price' => '8000',
                'description' => 'abc',
                'meta' => json_encode([
                    'set_discount' => true,
                    'discount' => '6800',
                    'label' => true,
                    'max_views' => 5
                ]),
                'status' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ];
        Plan::upsert($data, 'title');
    }
}
