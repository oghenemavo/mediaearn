<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Video Editor',
                'slug' => 'video_editor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        Role::upsert($data, 'name');
    }
}
