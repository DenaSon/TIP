<?php

namespace Database\Seeders;

use Domains\Topic\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            'جنگ',
            'ایران',
            'آمریکا',
            'حمله',
            'فوری',
        ];

        foreach ($topics as $topic) {

            Topic::firstOrCreate([
                'slug' => str($topic)->slug(),
            ], [
                'name' => $topic,
                'is_active' => true,
            ]);
        }
    }
}
