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

            'ai-agents' => [

                ['ai agent', 100],
                ['ai agents', 100],

                ['agentic ai', 100],
                ['agentic system', 95],
                ['agentic systems', 95],

                ['autonomous agent', 95],
                ['autonomous agents', 95],

                ['multi agent', 95],
                ['multi agents', 95],
                ['multi-agent', 95],
                ['multi-agent system', 95],

                ['agent orchestration', 100],
                ['agent workflow', 95],
                ['agent workflows', 95],

                ['agent framework', 90],
                ['agent frameworks', 90],

                ['agent runtime', 90],
                ['agent architecture', 90],

                ['agent memory', 95],
                ['agent planning', 95],

                ['tool calling', 100],
                ['function calling', 100],

                ['tool use', 100],
                ['tool usage', 95],

                ['computer use', 100],

                ['browser agent', 100],
                ['web agent', 95],

                ['autonomous workflow', 95],
                ['task execution', 90],

                ['agent execution', 95],
                ['task planning', 90],

                ['goal oriented agent', 95],

                ['agent platform', 85],
                ['agent infrastructure', 85],

                ['agent communication', 90],
                ['agent collaboration', 90],

                ['agent coordination', 90],

                ['digital worker', 90],

                ['autonomous workflow engine', 95],

                ['reasoning agent', 95],

                ['agent benchmark', 90],

                ['agent evaluation', 90],

                ['agent ecosystem', 80],

                ['operator agent', 90],

                ['computer agent', 90],

                ['agent loop', 90],

                ['agent planning system', 95],
            ],


            'coding-ai' => [

                ['coding ai', 100],
                ['ai coding', 100],

                ['ai programming', 100],
                ['code generation', 100],
                ['code assistant', 95],

                ['developer agent', 95],
                ['coding agent', 100],
                ['software engineering agent', 100],

                ['agentic coding', 100],

                ['code review ai', 95],
                ['automated code review', 95],

                ['code completion', 95],
                ['intelligent code completion', 95],

                ['ai ide', 100],
                ['ai powered ide', 95],

                ['developer workflow', 85],

                ['software engineering ai', 100],

                ['coding workflow', 90],

                ['repository analysis', 90],
                ['repository understanding', 90],

                ['codebase understanding', 100],
                ['codebase analysis', 95],

                ['pull request review', 90],
                ['pr review', 90],

                ['bug fixing agent', 95],

                ['automated debugging', 95],
                ['debugging assistant', 90],

                ['test generation', 100],
                ['unit test generation', 95],

                ['integration test generation', 95],

                ['code refactoring', 95],
                ['automated refactoring', 95],

                ['developer productivity', 85],

                ['coding benchmark', 90],
                ['software engineering benchmark', 90],

                ['code interpreter', 90],

                ['code execution agent', 95],

                ['coding copilot', 95],

                ['pair programming ai', 95],

                ['cursor', 100],

                ['claude code', 100],

                ['codex', 100],

                ['devin', 100],


                ['aider', 100],

                ['windsurf', 100],

                ['roo code', 95],

                ['bolt.new', 95],

                ['lovable', 95],

                ['vibe coding', 100],

                ['ai software engineer', 100],

                ['autonomous coding', 100],

                ['code generation benchmark', 90],

                ['developer assistant', 85],

                ['engineering productivity', 85],

                ['repository agent', 95],

                ['coding workflow automation', 90],

                ['software development automation', 90],
            ],


            'context-engineering' => [

                ['context engineering', 100],

                ['model context protocol', 100],
                ['mcp', 80],

                ['context management', 100],

                ['long context', 95],
                ['long context window', 95],
                ['extended context', 95],

                ['context window', 95],

                ['context retrieval', 95],

                ['agent memory', 100],
                ['persistent memory', 100],
                ['memory system', 95],
                ['memory architecture', 95],

                ['episodic memory', 95],
                ['long term memory', 95],

                ['memory retrieval', 95],

                ['tool use', 100],
                ['tool usage', 95],

                ['tool calling', 100],
                ['function calling', 100],

                ['tool execution', 95],

                ['retrieval augmented generation', 100],
                ['retrieval-augmented generation', 100],

                ['knowledge retrieval', 95],

                ['retrieval system', 95],

                ['retrieval pipeline', 90],

                ['vector retrieval', 95],

                ['semantic retrieval', 95],

                ['context injection', 95],

                ['context optimization', 95],

                ['context compression', 95],

                ['context selection', 95],

                ['context pruning', 95],

                ['prompt caching', 95],

                ['memory augmented', 95],

                ['knowledge grounding', 95],

                ['grounded generation', 95],

                ['retrieval benchmark', 90],

                ['memory benchmark', 90],

                ['context benchmark', 90],

                ['context aware agent', 95],

                ['memory aware agent', 95],

                ['tool enabled agent', 95],

                ['context aware reasoning', 95],

                ['agent context', 95],

                ['context orchestration', 95],

                ['knowledge integration', 90],

                ['knowledge pipeline', 90],

                ['retrieval workflow', 90],

                ['memory workflow', 90],

                ['vector database', 85],

                ['embedding retrieval', 90],

                ['semantic search', 85],

                ['knowledge graph retrieval', 95],
            ],

            'reasoning-models' => [

                ['reasoning model', 100],
                ['reasoning models', 100],

                ['reasoning ai', 95],
                ['ai reasoning', 95],

                ['reasoning llm', 95],
                ['reasoning capability', 95],

                ['logical reasoning', 95],
                ['multi step reasoning', 95],
                ['multi-hop reasoning', 95],

                ['chain of thought', 100],
                ['chain-of-thought', 100],
                ['cot reasoning', 95],

                ['test time compute', 100],
                ['test-time compute', 100],

                ['deliberative reasoning', 95],
                ['deep reasoning', 95],

                ['thinking model', 100],
                ['thinking models', 100],

                ['reasoning benchmark', 95],
                ['reasoning evaluation', 95],

                ['reasoning performance', 90],
                ['reasoning capability benchmark', 95],

                ['long reasoning', 90],
                ['extended thinking', 95],

                ['deep research', 95],

                ['inference-time scaling', 100],
                ['test-time scaling', 100],

                ['reasoning token', 90],
                ['thinking token', 90],

                ['system 2 reasoning', 95],

                ['slow thinking', 90],

                ['tree of thoughts', 100],
                ['tree-of-thoughts', 100],

                ['reasoning trace', 90],
                ['reasoning path', 90],

                ['deliberation', 85],

                ['self reflection', 90],
                ['self-reflection', 90],

                ['reflection tuning', 90],

                ['reasoning dataset', 85],

                ['mathematical reasoning', 95],
                ['math reasoning', 95],

                ['scientific reasoning', 90],

                ['reasoning task', 85],

                ['reasoning frontier', 90],

                ['reasoning agent', 80],

                ['reasoning architecture', 90],

                ['reasoning inference', 90],

                ['step by step reasoning', 95],

                ['planning and reasoning', 90],

                ['reasoning engine', 90],

                ['reasoning focused model', 95],

                ['reasoning-centric model', 95],

                ['model reasoning ability', 90],

                ['reasoning scaling law', 95],

                ['reasoning leaderboard', 85],

                ['reasoning challenge', 85],

                ['reasoning score', 85],

                ['frontier reasoning', 90],

                ['reasoning optimization', 85],

                ['thinking capability', 90],

                ['cognitive reasoning', 90],

                ['deep think', 95],

                ['thinking mode', 85],

                ['reasoning workflow', 85],
            ],

            'multimodal-ai' => [

                ['multimodal ai', 100],
                ['multimodal model', 100],
                ['multimodal models', 100],

                ['multimodal intelligence', 95],
                ['multimodal system', 95],

                ['vision language model', 100],
                ['vision-language model', 100],
                ['vlm', 95],

                ['image understanding', 95],
                ['visual reasoning', 100],

                ['image reasoning', 95],

                ['video understanding', 100],
                ['video reasoning', 95],

                ['audio understanding', 95],
                ['audio reasoning', 95],

                ['speech understanding', 90],
                ['speech reasoning', 90],

                ['vision model', 95],
                ['image model', 90],
                ['video model', 90],
                ['audio model', 90],

                ['multimodal benchmark', 95],
                ['multimodal evaluation', 95],

                ['multimodal capability', 95],
                ['multimodal performance', 90],

                ['cross modal', 95],
                ['cross-modal', 95],

                ['cross modal reasoning', 100],
                ['cross-modal reasoning', 100],

                ['image captioning', 90],
                ['visual grounding', 100],

                ['grounded generation', 95],

                ['document understanding', 95],

                ['vision encoder', 95],

                ['image-text model', 100],
                ['text-image model', 100],

                ['image to text', 90],
                ['text to image', 90],

                ['image generation model', 95],
                ['video generation model', 95],

                ['multimodal agent', 90],

                ['visual agent', 90],

                ['multimodal interaction', 90],

                ['multimodal inference', 90],

                ['multimodal architecture', 95],

                ['visual perception', 95],

                ['machine perception', 95],

                ['computer vision', 95],

                ['vision transformer', 95],

                ['visual encoder', 95],

                ['audio encoder', 95],

                ['speech-to-text', 90],
                ['speech to text', 90],

                ['text-to-speech', 90],
                ['text to speech', 90],

                ['multimodal workflow', 85],

                ['image generation', 85],
                ['video generation', 85],

                ['image synthesis', 90],

                ['visual intelligence', 95],

                ['multimodal frontier', 90],

                ['multimodal scaling', 90],

                ['multimodal learning', 90],

                ['multimodal foundation model', 100],

                ['vision foundation model', 95],

                ['audio foundation model', 95],

                ['embodied perception', 90],
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
