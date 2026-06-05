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
        $topics = $topics = [
            'ایران',
            'آمریکا',
            'اسرائیل',
            'روسیه',
            'چین',
            'اروپا',
            'انتخابات',
            'دیپلماسی',
            'تحریم',
            'دولت',

            'جنگ',
            'حمله',
            'موشک',
            'پهپاد',
            'انفجار',
            'نیروهای مسلح',
            'امنیت',
            'فوری',
            'بحران',
            'مذاکرات',

            'هوش مصنوعی',
            'فناوری',
            'استارتاپ',
            'اینترنت',
            'سایبری',
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
