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
