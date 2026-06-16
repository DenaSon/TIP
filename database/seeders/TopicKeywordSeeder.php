<?php

namespace Database\Seeders;

use App\Domains\Topic\Models\TopicKeyword;
use Domains\Topic\Models\Topic;
use Illuminate\Database\Seeder;

class TopicKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keywords = [

            'artificial-intelligence' => [
                ['artificial intelligence', 100],
                ['ai', 90],
                ['generative ai', 95],
                ['ai model', 80],
                ['ai system', 70],
                ['machine intelligence', 75],
                ['ai technology', 70],
                ['ai research', 70],
                ['ai development', 65],
                ['foundation model', 85],
            ],

            'large-language-models' => [
                ['large language model', 100],
                ['large language models', 100],
                ['llm', 95],
                ['language model', 90],
                ['foundation model', 85],
                ['generative model', 80],
                ['transformer model', 80],
                ['multimodal model', 75],
                ['reasoning model', 75],
                ['open weight model', 70],
            ],

            'openai' => [
                ['openai', 100],
                ['chatgpt', 95],
                ['gpt', 90],
                ['gpt-4', 95],
                ['gpt-5', 100],
                ['o3', 85],
                ['openai api', 95],
                ['openai model', 90],
                ['openai release', 80],
                ['sam altman', 80],
            ],

            'ai-agents' => [
                ['ai agent', 100],
                ['ai agents', 100],
                ['autonomous agent', 90],
                ['agentic ai', 95],
                ['agent workflow', 85],
                ['agent framework', 85],
                ['multi-agent', 90],
                ['ai assistant', 75],
                ['autonomous system', 70],
                ['task automation agent', 80],
            ],

            'anthropic' => [
                ['anthropic', 100],
                ['claude', 100],
                ['claude ai', 95],
                ['claude opus', 95],
                ['claude sonnet', 95],
                ['claude model', 90],
                ['anthropic api', 90],
                ['anthropic release', 85],
                ['dario amodei', 80],
                ['constitutional ai', 80],
            ],

            'google-ai' => [
                ['google ai', 100],
                ['gemini', 100],
                ['gemini ai', 95],
                ['gemini model', 95],
                ['google deepmind', 100],
                ['deepmind', 95],
                ['project astra', 90],
                ['veo', 90],
                ['gemma', 90],
                ['demis hassabis', 80],
            ],

            'ai-infrastructure' => [
                ['ai infrastructure', 100],
                ['ai hardware', 90],
                ['ai compute', 95],
                ['ai accelerator', 90],
                ['data center', 85],
                ['inference infrastructure', 95],
                ['model serving', 90],
                ['gpu cluster', 95],
                ['ai training infrastructure', 100],
                ['inference engine', 85],
            ],

            'cybersecurity' => [
                ['cybersecurity', 100],
                ['cyber security', 100],
                ['security breach', 95],
                ['data breach', 95],
                ['ransomware', 95],
                ['malware', 90],
                ['phishing', 90],
                ['cyber attack', 95],
                ['vulnerability', 85],
                ['zero day', 100],
            ],

            'nvidia' => [
                ['nvidia', 100],
                ['jensen huang', 100],
                ['h100', 95],
                ['h200', 95],
                ['b200', 95],
                ['blackwell', 100],
                ['dgx', 90],
                ['cuda', 95],
                ['nvidia gpu', 95],
                ['ai chip', 85],
                ['nvidia data center', 90],
                ['nvlink', 90],
                ['grace blackwell', 95],
                ['nvidia earnings', 80],
            ],

        ];

        foreach ($keywords as $slug => $items) {

            $topic = Topic::where('slug', $slug)->first();

            if (! $topic) {
                continue;
            }

            foreach ($items as [$keyword, $weight]) {

                TopicKeyword::updateOrCreate(
                    [
                        'topic_id' => $topic->id,
                        'keyword' => strtolower($keyword),
                    ],
                    [
                        'weight' => $weight,
                    ]
                );
            }
        }
    }
}
