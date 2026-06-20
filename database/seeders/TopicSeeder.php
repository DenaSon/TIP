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
                'name' => 'AI Agents',
                'slug' => 'ai-agents',
                'description' => 'Autonomous agents, agentic systems, task execution, multi-agent workflows and AI assistants.',
            ],

            [
                'name' => 'Coding AI',
                'slug' => 'coding-ai',
                'description' => 'AI-powered software development, code generation, AI IDEs and developer assistants.',
            ],

            [
                'name' => 'Context Engineering',
                'slug' => 'context-engineering',
                'description' => 'Context management, MCP, memory systems, tool usage, RAG and agent context architectures.',
            ],

            [
                'name' => 'AI Infrastructure',
                'slug' => 'ai-infrastructure',
                'description' => 'Inference, compute, GPUs, serving systems, vector databases and AI deployment infrastructure.',
            ],

            [
                'name' => 'Reasoning Models',
                'slug' => 'reasoning-models',
                'description' => 'Reasoning capabilities, planning, inference-time compute and advanced thinking models.',
            ],

            [
                'name' => 'Multimodal AI',
                'slug' => 'multimodal-ai',
                'description' => 'Vision-language models, image generation, video generation, audio models, speech understanding and multimodal intelligence.',
            ],

            [
                'name' => 'Voice AI',
                'slug' => 'voice-ai',
                'description' => 'Speech recognition, speech synthesis, voice assistants, conversational audio systems and spoken language intelligence.',
            ],

            [
                'name' => 'Foundation Models',
                'slug' => 'foundation-models',
                'description' => 'Foundation models, pretraining, post-training, scaling laws, RLHF, model architecture and model development.',
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
