<?php

namespace Database\Seeders;

use Domains\Topic\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [

            [
                'name' => 'Artificial Intelligence',
                'slug' => 'artificial-intelligence',
                'description' => 'General artificial intelligence news, research, products and ecosystem.',
            ],

            [
                'name' => 'Large Language Models',
                'slug' => 'large-language-models',
                'description' => 'LLMs, foundation models, multimodal models and language model advancements.',
            ],

            [
                'name' => 'OpenAI',
                'slug' => 'openai',
                'description' => 'OpenAI products, models, announcements and ecosystem.',
            ],

            [
                'name' => 'AI Agents',
                'slug' => 'ai-agents',
                'description' => 'Autonomous agents, agentic systems and multi-agent workflows.',
            ],

            [
                'name' => 'Anthropic',
                'slug' => 'anthropic',
                'description' => 'Anthropic, Claude models and company related developments.',
            ],

            [
                'name' => 'Google AI',
                'slug' => 'google-ai',
                'description' => 'Google AI, DeepMind, Gemini and related products.',
            ],

            [
                'name' => 'AI Infrastructure',
                'slug' => 'ai-infrastructure',
                'description' => 'AI compute, inference, hardware and infrastructure ecosystem.',
            ],

            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Cyber attacks, vulnerabilities, malware and security incidents.',
            ],

            [
                'name' => 'NVIDIA',
                'slug' => 'nvidia',
                'description' => 'NVIDIA products, GPUs, AI hardware and company developments.',
            ],
            [
                'name' => 'Crypto',
                'slug' => 'crypto',
                'description' => 'Cryptocurrency, blockchain, digital assets, DeFi and Web3 ecosystem.',
            ],

            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Technology companies, software, hardware, cloud computing and digital innovation.',
            ],

            [
                'name' => 'Startups & Business',
                'slug' => 'startups-business',
                'description' => 'Startups, venture capital, entrepreneurship, investments and business growth.',
            ],

        ];

        foreach ($topics as $topic) {

            Topic::updateOrCreate(
                [
                    'slug' => $topic['slug'],
                ],
                [
                    'name' => $topic['name'],
                    'description' => $topic['description'],
                    'is_active' => true,
                ]
            );

        }
    }
}
