<?php

namespace Database\Seeders;

use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
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
                'title' => 'Why is a Video is not loading?',
                'description' => 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.
                Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Why isn\'t there a HD version of this video?',
                'description' => 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for "lorem ipsum" will uncover many web sites still in their infancy.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Why is the sound distorted?',
                'description' => 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Why is the Video stuttering, buffering or randomly stopping?',
                'description' => 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'When I change the quality of a video, nothing happens.',
                'description' => 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Why isn\'t the video starting at the beginning?',
                'description' => 'Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'How can I contact you?',
                'description' => "The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        Faq::upsert($data, 'title');
    }
}
