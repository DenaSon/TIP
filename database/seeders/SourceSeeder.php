<?php

namespace Database\Seeders;

use Domains\Source\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [

            [
                'name' => 'TechCrunch',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://techcrunch.com/feed/',
                ],
            ],

            [
                'name' => 'The Verge',
                'type' => 'rss',
                'authority_score' => 90,
                'config' => [
                    'url' => 'https://www.theverge.com/rss/index.xml',
                ],
            ],

            [
                'name' => 'Ars Technica',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://feeds.arstechnica.com/arstechnica/index',
                ],
            ],

            [
                'name' => 'VentureBeat AI',
                'type' => 'rss',
                'authority_score' => 90,
                'config' => [
                    'url' => 'https://venturebeat.com/category/ai/feed/',
                ],
            ],

            [
                'name' => 'MIT Technology Review AI',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://www.technologyreview.com/topic/artificial-intelligence/feed/',
                ],
            ],

            [
                'name' => 'Hugging Face Blog',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://huggingface.co/blog/feed.xml',
                ],
            ],

            [
                'name' => 'DeepLearning.AI',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://www.deeplearning.ai/the-batch/feed/',
                ],
            ],

            [
                'name' => 'The Gradient',
                'type' => 'rss',
                'authority_score' => 90,
                'config' => [
                    'url' => 'https://thegradient.pub/rss/',
                ],
            ],

            [
                'name' => 'Simon Willison',
                'type' => 'rss',
                'authority_score' => 85,
                'config' => [
                    'url' => 'https://simonwillison.net/atom/everything/',
                ],
            ],

            [
                'name' => 'OpenAI News',
                'type' => 'rss',
                'authority_score' => 100,
                'config' => [
                    'url' => 'https://openai.com/news/rss.xml',
                ],
            ],

            [
                'name' => 'OpenAI Blog',
                'type' => 'rss',
                'authority_score' => 100,
                'config' => [
                    'url' => 'https://openai.com/blog/rss.xml',
                ],
            ],

            [
                'name' => 'Anthropic News',
                'type' => 'rss',
                'authority_score' => 100,
                'config' => [
                    'url' => 'https://www.anthropic.com/news/rss.xml',
                ],
            ],

            [
                'name' => 'Google DeepMind',
                'type' => 'rss',
                'authority_score' => 100,
                'config' => [
                    'url' => 'https://deepmind.google/blog/rss.xml',
                ],
            ],

            [
                'name' => 'Google AI Blog',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://blog.google/technology/ai/rss/',
                ],
            ],

            [
                'name' => 'NVIDIA Blog',
                'type' => 'rss',
                'authority_score' => 100,
                'config' => [
                    'url' => 'https://blogs.nvidia.com/feed/',
                ],
            ],

            [
                'name' => 'NVIDIA Developer',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://developer.nvidia.com/blog/feed/',
                ],
            ],

            [
                'name' => 'Krebs On Security',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://krebsonsecurity.com/feed/',
                ],
            ],

            [
                'name' => 'The Hacker News',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://feeds.feedburner.com/TheHackersNews',
                ],
            ],

            [
                'name' => 'BleepingComputer',
                'type' => 'rss',
                'authority_score' => 95,
                'config' => [
                    'url' => 'https://www.bleepingcomputer.com/feed/',
                ],
            ],

        ];

        foreach ($sources as $source) {

            Source::updateOrCreate(
                [
                    'name' => $source['name'],
                ],
                [
                    'type' => $source['type'],
                    'status' => 'active',
                    'authority_score' => $source['authority_score'],
                    'config' => $source['config'],
                ]
            );
        }
    }
}
