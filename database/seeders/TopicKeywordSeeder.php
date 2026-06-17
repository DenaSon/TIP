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

                ['machine learning', 95],
                ['deep learning', 95],
                ['neural network', 90],
                ['neural networks', 90],
                ['artificial general intelligence', 100],
                ['agi', 95],
                ['multimodal ai', 90],
                ['computer vision', 90],
                ['vision model', 85],
                ['speech model', 85],
                ['voice model', 85],
                ['reasoning ai', 90],
                ['reasoning system', 85],
                ['ai benchmark', 80],
                ['model evaluation', 80],
                ['ai alignment', 85],
                ['alignment research', 80],
                ['reinforcement learning', 90],
                ['rlhf', 95],
                ['fine tuning', 85],
                ['synthetic data', 80],
                ['ai safety', 90],
                ['frontier model', 90],
                ['open source ai', 85],
                ['ai ecosystem', 75],
                ['multimodal intelligence', 90],
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

                ['transformer', 95],
                ['attention mechanism', 85],
                ['context window', 90],
                ['tokenization', 85],
                ['tokenizer', 85],
                ['embedding model', 90],
                ['embeddings', 85],
                ['reranker', 90],
                ['retrieval augmented generation', 95],
                ['rag', 95],
                ['long context', 90],
                ['million token context', 95],
                ['mixture of experts', 95],
                ['moe', 95],
                ['reasoning model', 95],
                ['reasoning llm', 95],
                ['multimodal llm', 95],
                ['vision language model', 90],
                ['vlm', 90],
                ['open weights', 85],
                ['instruction tuning', 85],
                ['pretraining', 85],
                ['post training', 85],
                ['language reasoning', 80],
                ['agent model', 80],
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

                ['openai sdk', 90],
                ['openai platform', 90],
                ['assistants api', 95],
                ['responses api', 95],
                ['chat completions', 90],
                ['openai reasoning', 90],
                ['codex', 95],
                ['operator', 95],
                ['sora', 100],
                ['openai agents sdk', 95],
                ['deep research', 90],
                ['openai safety', 85],
                ['openai developer', 85],
                ['gpt model', 90],
                ['chatgpt enterprise', 85],
                ['openai ecosystem', 80],
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

                ['agent orchestration', 95],
                ['agent platform', 90],
                ['tool calling', 95],
                ['tool use', 95],
                ['tool using agent', 95],
                ['computer use', 95],
                ['browser agent', 95],
                ['coding agent', 95],
                ['research agent', 90],
                ['autonomous workflow', 90],
                ['agent benchmark', 90],
                ['agent evaluation', 85],
                ['agent memory', 85],
                ['agent planning', 85],
                ['multi agent system', 95],
                ['agent runtime', 85],
                ['agent execution', 85],
                ['operator agent', 90],
                ['workflow automation', 80],
                ['digital worker', 80],
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

                ['claude code', 100],
                ['claude desktop', 90],
                ['claude max', 90],
                ['claude 4', 100],
                ['opus 4', 95],
                ['sonnet 4', 95],
                ['anthropic safety', 85],
                ['anthropic research', 85],
                ['anthropic models', 90],
                ['anthropic developer', 85],
                ['model context protocol', 95],
                ['mcp', 90],
                ['computer use', 95],
                ['constitutional training', 85],
                ['anthropic ecosystem', 80],
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

                ['gemini 2.5', 100],
                ['gemini flash', 95],
                ['gemini pro', 95],
                ['gemini live', 90],
                ['deep think', 90],
                ['deepmind research', 90],
                ['google model', 85],
                ['google ai studio', 95],
                ['vertex ai', 95],
                ['imagen', 95],
                ['project mariner', 90],
                ['alphafold', 95],
                ['google agentspace', 90],
                ['google reasoning', 85],
                ['gemma model', 95],
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

                ['inference', 90],
                ['model inference', 95],
                ['distributed inference', 95],
                ['serving', 85],
                ['model deployment', 90],
                ['inference provider', 90],
                ['throughput', 80],
                ['latency', 80],
                ['kv cache', 90],
                ['tensor parallelism', 95],
                ['pipeline parallelism', 95],
                ['distributed training', 95],
                ['training cluster', 95],
                ['model hosting', 85],
                ['ai workload', 80],
                ['compute cluster', 90],
                ['gpu infrastructure', 95],
                ['vector database', 85],
                ['embedding infrastructure', 85],
                ['vllm', 100],
                ['sglang', 95],
                ['tgi', 90],
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

                ['exploit', 90],
                ['security vulnerability', 95],
                ['critical vulnerability', 95],
                ['cve', 100],
                ['remote code execution', 100],
                ['rce', 95],
                ['privilege escalation', 95],
                ['security patch', 85],
                ['threat actor', 90],
                ['data leak', 90],
                ['credential theft', 90],
                ['supply chain attack', 95],
                ['botnet', 90],
                ['nation state attack', 90],
                ['security incident', 90],
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

                ['gb200', 100],
                ['grace hopper', 95],
                ['tensor core', 90],
                ['nvidia inference', 90],
                ['nvidia ai', 90],
                ['nvidia platform', 85],
                ['nvidia hardware', 85],
                ['cuda kernel', 90],
                ['cuda acceleration', 90],
                ['nims', 90],
                ['nvidia cosmos', 95],
                ['dgx spark', 95],
                ['nvidia reasoning', 85],
                ['nvidia developer', 80],
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
