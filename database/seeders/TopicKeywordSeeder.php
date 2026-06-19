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

                ['artificial intelligence', 80],
                ['ai', 70],
                ['generative ai', 80],

                ['ai model', 80],
                ['ai system', 70],
                ['machine intelligence', 75],

                ['ai technology', 60],
                ['ai research', 60],
                ['ai development', 60],

                ['machine learning', 75],
                ['deep learning', 75],

                ['neural network', 90],
                ['neural networks', 90],

                ['artificial general intelligence', 100],
                ['agi', 95],

                ['multimodal ai', 90],

                ['computer vision', 90],

                ['vision model', 90],
                ['speech model', 90],
                ['voice model', 90],

                ['reasoning ai', 90],
                ['reasoning system', 85],

                ['ai benchmark', 90],
                ['model evaluation', 90],

                ['ai alignment', 95],
                ['alignment research', 90],

                ['reinforcement learning', 95],
                ['rlhf', 100],

                ['fine tuning', 85],

                ['synthetic data', 80],

                ['ai safety', 95],

                ['frontier model', 95],

                ['open source ai', 85],

                ['ai ecosystem', 60],

                ['multimodal intelligence', 90],

                ['ai assistant', 60],
                ['ai assistants', 60],

                ['ai application', 60],
                ['ai applications', 60],

                ['ai platform', 60],

                ['ai startup', 60],
                ['ai startups', 60],

                ['ai innovation', 60],

                ['intelligent system', 80],
                ['intelligent systems', 80],

                ['autonomous system', 85],
                ['autonomous systems', 85],

                ['cognitive computing', 85],

                ['predictive model', 80],
                ['predictive analytics', 80],

                ['machine perception', 90],

                ['knowledge model', 75],

                ['knowledge representation', 90],

                ['decision intelligence', 90],

                ['decision support system', 80],

                ['ai workflow', 60],

                ['human ai collaboration', 90],

                ['human in the loop', 85],

                ['agentic ai', 70],
                ['agentic system', 65],

                ['ai capability', 75],

                ['emergent capability', 90],
                ['emergent behavior', 90],

                ['world model', 95],

                ['self improving model', 90],

                ['model distillation', 90],
                ['distilled model', 90],

                ['inference model', 80],
                ['model inference', 80],

                ['ai deployment', 75],

                ['production ai', 65],

                ['enterprise ai', 65],

                ['ai adoption', 60],

                ['ai transformation', 60],

                ['ai powered', 50],
                ['ai driven', 50],

                ['intelligent agent', 65],

                ['intelligent automation', 85],

                ['automation platform', 70],

                ['cognitive agent', 65],

                ['neural architecture', 95],

                ['ai breakthrough', 80],

                ['ai innovation lab', 75],
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
                ['prompt engineering', 95],
                ['system prompt', 90],
                ['prompt template', 85],

                ['chain of thought', 95],
                ['cot reasoning', 95],

                ['few shot learning', 90],
                ['zero shot learning', 90],

                ['in context learning', 95],

                ['test time compute', 90],

                ['tool calling', 95],
                ['function calling', 95],

                ['structured output', 85],

                ['json mode', 80],

                ['model routing', 85],

                ['speculative decoding', 90],

                ['kv cache', 85],

                ['context compression', 85],

                ['semantic retrieval', 90],

                ['vector database', 90],
                ['vector search', 90],

                ['semantic search', 90],

                ['embedding space', 85],

                ['latent space', 80],

                ['model serving', 85],

                ['inference engine', 90],

                ['distributed inference', 90],

                ['quantization', 95],
                ['model quantization', 95],

                ['distillation', 90],
                ['knowledge distillation', 90],

                ['parameter efficient fine tuning', 95],
                ['peft', 95],

                ['lora', 95],
                ['qlora', 95],

                ['adapter tuning', 90],

                ['model checkpoint', 80],

                ['benchmark suite', 80],

                ['hallucination', 95],

                ['grounded generation', 90],

                ['model alignment', 90],

                ['instruction following', 90],

                ['synthetic training data', 85],

                ['training corpus', 80],

                ['pretrained model', 90],

                ['inference cost', 80],

                ['token efficiency', 85],

                ['model latency', 80],

                ['agentic reasoning', 90],

                ['planning model', 85],

                ['tool use', 90],

                ['long horizon reasoning', 90],

                ['multi step reasoning', 90],
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
                ['gpt 4o', 100],
                ['gpt-4o', 100],

                ['gpt 4.1', 95],
                ['gpt-4.1', 95],

                ['gpt 4.5', 95],
                ['gpt-4.5', 95],

                ['gpt image', 90],
                ['image generation', 80],

                ['openai image', 90],

                ['openai voice', 90],

                ['realtime api', 95],

                ['computer use', 95],

                ['computer use api', 95],

                ['agent mode', 90],

                ['agent workflow', 85],

                ['openai agents', 95],

                ['agent toolkit', 85],

                ['openai tools', 85],

                ['function calling', 90],

                ['structured outputs', 90],

                ['json schema output', 85],

                ['model spec', 90],

                ['openai evals', 90],

                ['evals', 85],

                ['openai cookbook', 80],

                ['openai developer conference', 85],

                ['devday', 95],

                ['chatgpt plus', 85],

                ['chatgpt pro', 85],

                ['chatgpt team', 85],

                ['chatgpt business', 85],

                ['chatgpt desktop', 80],

                ['chatgpt search', 95],

                ['chatgpt memory', 80],

                ['chatgpt voice', 90],

                ['advanced voice mode', 95],

                ['openai operator', 95],

                ['openai codex', 95],

                ['codex cli', 95],

                ['openai research', 85],

                ['alignment team', 80],

                ['superalignment', 85],

                ['openai startup fund', 85],

                ['openai for developers', 85],

                ['openai ecosystem fund', 80],

                ['openai infrastructure', 80],

                ['stargate project', 95],
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
                ['agentic workflow', 95],

                ['agent architecture', 90],

                ['agent builder', 90],

                ['agent builder platform', 90],

                ['agent development', 85],

                ['agent lifecycle', 80],

                ['agent collaboration', 90],

                ['collaborative agents', 90],

                ['cooperative agents', 90],

                ['hierarchical agents', 90],

                ['supervisor agent', 95],

                ['manager agent', 90],

                ['worker agent', 90],

                ['planner agent', 95],

                ['executor agent', 95],

                ['agent communication', 90],

                ['agent coordination', 90],

                ['agent delegation', 90],

                ['task decomposition', 95],

                ['goal oriented agent', 90],

                ['goal driven agent', 90],

                ['long horizon agent', 95],

                ['agent loop', 85],

                ['agent state', 80],

                ['persistent memory', 85],

                ['episodic memory', 90],

                ['agent reflection', 95],

                ['self reflection', 90],

                ['reflection loop', 90],

                ['self correction', 90],

                ['self improvement', 85],

                ['planning and execution', 90],

                ['reasoning and acting', 95],

                ['react agent', 100],

                ['react framework', 90],

                ['agent environment', 80],

                ['agent simulation', 85],

                ['agent sandbox', 80],

                ['human in the loop', 90],

                ['human approval', 85],

                ['agent governance', 85],

                ['agent monitoring', 85],

                ['agent observability', 90],

                ['agent tracing', 90],

                ['agent reliability', 85],

                ['agent safety', 90],

                ['agent guardrails', 95],

                ['agent deployment', 80],

                ['production agent', 85],

                ['enterprise agent', 85],

                ['voice agent', 95],

                ['customer support agent', 85],

                ['sales agent', 85],

                ['marketing agent', 85],

                ['engineering agent', 90],

                ['software agent', 90],

                ['autonomous coding', 95],

                ['code generation agent', 90],

                ['agent sdk', 95],

                ['agent protocol', 90],

                ['agent network', 90],
            ],

            'anthropic' => [

                ['anthropic', 100],
                ['claude', 150],
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
                ['claude pro', 90],

                ['claude team', 85],

                ['claude enterprise', 90],

                ['claude web search', 90],

                ['claude artifacts', 100],

                ['artifact', 85],

                ['artifacts workspace', 90],

                ['extended thinking', 100],

                ['thinking model', 90],

                ['hybrid reasoning', 85],

                ['anthropic console', 90],

                ['anthropic platform', 90],

                ['anthropic sdk', 90],

                ['anthropic prompt engineering', 85],

                ['anthropic evals', 85],

                ['claude sdk', 90],

                ['claude api', 95],

                ['claude integration', 85],

                ['claude workflow', 85],


                ['claude agents', 90],

                ['anthropic agents', 90],

                ['claude memory', 85],

                ['claude projects', 95],

                ['claude knowledge', 85],

                ['claude workspace', 85],

                ['anthropic infrastructure', 80],

                ['anthropic alignment', 90],

                ['alignment research', 85],

                ['frontier safety', 90],

                ['frontier model safety', 90],

                ['responsible scaling policy', 95],

                ['rsp', 90],

                ['ai safety levels', 85],

                ['safety case', 85],

                ['alignment science', 90],

                ['anthropic economics index', 90],

                ['economic index', 80],

                ['long context model', 90],

                ['200k context', 95],

                ['context scaling', 85],

                ['anthropic benchmark', 85],

                ['claude benchmark', 85],

                ['anthropic evaluation', 85],
            ],

            'google-ai' => [

                ['google ai', 120],
                ['gemini', 150],
                ['gemini ai', 150],
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
                ['google ai platform', 90],

                ['gemini api', 95],

                ['gemini advanced', 95],

                ['gemini nano', 95],

                ['gemini multimodal', 90],

                ['gemini reasoning', 95],

                ['gemini cli', 90],

                ['gemini code assist', 95],

                ['google ai sdk', 90],

                ['google ai developer', 85],

                ['google ai ecosystem', 85],

                ['google ai infrastructure', 85],

                ['google ai research', 90],

                ['google research', 85],

                ['deepmind scientist', 80],

                ['deepmind breakthrough', 85],

                ['deepmind model', 90],

                ['deepmind agents', 90],

                ['deepmind reasoning', 90],

                ['deepmind safety', 85],

                ['deepmind alignment', 85],

                ['alphageometry', 95],

                ['alphageometry 2', 100],

                ['alphacode', 95],

                ['alphacode 2', 100],

                ['synthid', 95],

                ['learnlm', 90],

                ['notebooklm', 100],

                ['google notebooklm', 100],

                ['audio overview', 90],

                ['vertex ai search', 95],

                ['vertex ai agent builder', 100],

                ['vertex ai agents', 95],

                ['vertex ai platform', 90],

                ['vertex ai studio', 90],

                ['google workspace ai', 85],

                ['workspace ai', 85],

                ['google ai overview', 90],

                ['ai overview', 90],

                ['search generative experience', 95],

                ['sge', 90],

                ['tpu', 100],

                ['tensor processing unit', 100],

                ['trillium', 100],

                ['google cloud ai', 95],

                ['google cloud inference', 90],

                ['google cloud vertex', 95],

                ['multimodal reasoning', 90],

                ['world model', 90],

                ['video generation model', 90],

                ['video understanding', 85],

                ['scientific discovery ai', 85],
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
                ['gpu', 100],

                ['h100', 100],
                ['h200', 100],

                ['b100', 100],
                ['b200', 100],

                ['blackwell', 100],

                ['tensor core', 90],

                ['ai chip', 95],
                ['ai chips', 95],

                ['ai server', 95],
                ['ai servers', 95],

                ['compute infrastructure', 95],

                ['compute capacity', 90],

                ['compute scaling', 90],

                ['training compute', 95],

                ['inference compute', 95],

                ['cloud gpu', 95],

                ['gpu cloud', 95],

                ['gpu provider', 90],

                ['cloud inference', 90],

                ['server rack', 85],

                ['rack scale', 90],

                ['hyperscaler', 95],

                ['hyperscale datacenter', 95],

                ['ai factory', 100],

                ['ai supercomputer', 100],

                ['supercomputer', 90],

                ['cluster scheduler', 85],

                ['resource allocation', 80],

                ['load balancing', 80],

                ['distributed systems', 85],

                ['high performance computing', 95],
                ['hpc', 95],

                ['compute fabric', 90],

                ['network fabric', 90],

                ['rdma', 95],

                ['infiniband', 100],

                ['nvlink', 100],

                ['cuda', 100],

                ['cudnn', 90],

                ['tensorrt', 100],

                ['triton inference server', 100],

                ['model optimization', 85],

                ['inference optimization', 90],

                ['serving stack', 85],

                ['batch inference', 85],

                ['real time inference', 90],

                ['vector store', 85],

                ['feature store', 80],

                ['embedding service', 85],

                ['training pipeline', 90],

                ['mlops', 95],

                ['llmops', 100],

                ['observability', 80],

                ['model monitoring', 85],

                ['ai platform infrastructure', 90],
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
                ['threat intelligence', 95],

                ['threat hunting', 95],

                ['attack surface', 90],

                ['attack vector', 90],

                ['incident response', 95],

                ['security operations center', 95],
                ['soc', 90],

                ['security operations', 90],

                ['intrusion detection', 95],
                ['intrusion prevention', 95],

                ['endpoint security', 90],
                ['endpoint detection and response', 100],
                ['edr', 95],

                ['extended detection and response', 100],
                ['xdr', 95],

                ['identity security', 90],

                ['identity and access management', 95],
                ['iam', 90],

                ['access control', 85],

                ['multi factor authentication', 95],
                ['mfa', 90],

                ['authentication bypass', 95],

                ['account takeover', 95],

                ['credential stuffing', 95],

                ['password spraying', 95],

                ['lateral movement', 95],

                ['persistence mechanism', 90],

                ['command and control', 95],
                ['c2 server', 95],

                ['indicators of compromise', 95],
                ['ioc', 90],

                ['security telemetry', 85],

                ['forensics', 90],
                ['digital forensics', 95],

                ['penetration testing', 95],
                ['pentest', 95],

                ['red team', 95],
                ['blue team', 95],

                ['adversary simulation', 90],

                ['security audit', 85],

                ['risk assessment', 85],

                ['threat detection', 95],

                ['cloud security', 95],

                ['application security', 90],

                ['network security', 95],

                ['container security', 90],

                ['kubernetes security', 95],

                ['api security', 95],

                ['security misconfiguration', 95],

                ['exposed database', 95],

                ['data exposure', 90],

                ['secret leakage', 95],

                ['credential exposure', 95],

                ['security advisory', 90],

                ['vulnerability disclosure', 95],

                ['bug bounty', 95],

                ['security researcher', 85],

                ['exploit chain', 95],

                ['active exploitation', 100],

                ['threat campaign', 90],
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
                ['a100', 95],

                ['rtx', 85],
                ['rtx pro', 85],

                ['nvl72', 100],

                ['nvl', 90],

                ['nvidia omniverse', 100],
                ['omniverse', 95],

                ['earth 2', 90],

                ['physical ai', 100],

                ['robotics foundation model', 95],

                ['isaac', 95],
                ['isaac sim', 95],

                ['digital twin', 95],

                ['nvidia drive', 95],

                ['drive thor', 100],

                ['thor', 85],

                ['bluefield', 95],

                ['spectrum x', 100],

                ['infiniband', 100],

                ['network fabric', 90],

                ['ai factory', 100],

                ['gpu cloud', 95],

                ['accelerated computing', 100],

                ['nvidia enterprise', 90],

                ['nvidia ai enterprise', 95],

                ['nvidia inference microservices', 95],

                ['nvidia nim', 100],

                ['nemo', 95],

                ['nvidia nemo', 100],

                ['nvidia dgx cloud', 95],

                ['enterprise ai platform', 90],

                ['gpu infrastructure', 90],

                ['nvidia software stack', 90],

                ['tensorrt', 100],

                ['tensorrt llm', 100],

                ['cudnn', 95],

                ['nvswitch', 95],

                ['gpu scaling', 90],

                ['nvidia research', 85],

                ['ai supercomputer', 95],

                ['data center gpu', 95],

                ['sovereign ai', 100],

                ['nvidia partner network', 80],
            ],

            'crypto' => [

                ['bitcoin', 100],
                ['btc', 100],

                ['ethereum', 100],
                ['eth', 100],

                ['crypto', 90],
                ['cryptocurrency', 90],

                ['blockchain', 90],

                ['solana', 80],
                ['sol', 80],

                ['binance', 80],
                ['coinbase', 80],

                ['token', 80],
                ['tokens', 80],

                ['altcoin', 80],
                ['altcoins', 80],

                ['defi', 80],

                ['web3', 80],

                ['airdrop', 70],

                ['wallet', 70],

                ['stablecoin', 70],

                ['usdt', 70],

                ['staking', 70],

                ['mining', 70],

                ['smart contract', 70],

                ['smart contracts', 70],

                ['dex', 60],

                ['exchange', 60],

                ['nft', 60],

                ['metamask', 60],

                ['crypto market', 60],

                ['xrp', 80],
                ['ripple', 80],

                ['bnb', 80],

                ['dogecoin', 80],
                ['doge', 80],

                ['cardano', 80],
                ['ada', 80],

                ['tron', 80],
                ['trx', 80],

                ['polkadot', 80],
                ['dot', 80],

                ['chainlink', 80],
                ['link', 80],

                ['avalanche', 80],
                ['avax', 80],

                ['polygon', 80],
                ['matic', 80],

                ['near', 80],

                ['arbitrum', 80],
                ['arb', 80],

                ['optimism', 80],


                ['uniswap', 80],
                ['uni', 80],

                ['aptos', 80],

                ['sui', 80],

                ['pepe', 80],

                ['shiba inu', 80],
                ['shiba', 80],
                ['shib', 80],

                ['ton', 80],
                ['toncoin', 80],

                ['stellar', 80],
                ['xlm', 80],

                ['hedera', 80],
                ['hbar', 80],

                ['kaspa', 80],
                ['kas', 80],

                ['algorand', 80],
                ['algo', 80],
            ],

            'technology' => [

                ['technology', 70],
                ['tech', 70],

                ['apple', 90],
                ['iphone', 90],
                ['ipad', 80],
                ['macbook', 80],
                ['mac', 80],
                ['ios', 80],

                ['microsoft', 90],
                ['windows', 80],

                ['google', 60],
                ['android', 80],
                ['chrome', 70],

                ['meta', 60],
                ['facebook', 80],
                ['instagram', 80],
                ['whatsapp', 80],

                ['amazon', 60],

                ['samsung', 80],

                ['intel', 80],
                ['amd', 80],

                ['qualcomm', 70],

                ['huawei', 70],

                ['tesla', 70],

                ['cloud', 70],

                ['aws', 80],
                ['azure', 80],
                ['gcp', 80],

                ['software', 70],
                ['hardware', 70],

                ['linux', 70],

                ['github', 70],

                ['datacenter', 70],
                ['data center', 70],

                ['semiconductor', 70],

                ['chip', 60],
                ['chips', 60],

                ['arm', 80],

                ['oppo', 70],
                ['vivo', 70],
                ['oneplus', 70],

                ['lenovo', 70],
                ['asus', 70],
                ['dell', 70],
                ['hp', 70],
                ['acer', 70],

                ['processor', 70],

                ['ubuntu', 70],
                ['debian', 70],
                ['fedora', 70],

                ['red hat', 70],

                ['gitlab', 70],

                ['open source', 60],

                ['developer', 45],
                ['developers', 45],

                ['programming', 50],

                ['coding', 40],

                ['api', 50],

                ['sdk', 70],

                ['smartphone', 80],

                ['laptop', 80],

                ['tablet', 70],

                ['wearable', 70],

                ['smartwatch', 70],

                ['vr', 50],

                ['ar', 50],

                ['mixed reality', 70],

                ['headset', 70],
            ],

            'startups-business' => [

                ['startup', 100],
                ['startups', 100],

                ['business', 100],

                ['founder', 90],
                ['co-founder', 90],

                ['entrepreneur', 90],
                ['entrepreneurship', 90],

                ['funding', 90],

                ['investment', 90],
                ['investments', 90],

                ['investor', 80],
                ['investors', 80],

                ['venture capital', 90],
                ['vc', 90],

                ['seed round', 90],

                ['series a', 90],
                ['series b', 90],
                ['series c', 90],

                ['valuation', 80],

                ['ipo', 90],

                ['acquisition', 90],
                ['acquire', 80],
                ['acquired', 80],

                ['merger', 80],

                ['revenue', 80],
                ['profit', 80],

                ['growth', 30],

                ['market share', 80],

                ['enterprise', 40],

                ['saas', 80],

                ['subscription', 70],

                ['fintech', 80],

                ['ecommerce', 80],
                ['marketplace', 80],

                ['b2b', 70],
                ['b2c', 70],

                ['product market fit', 80],

                ['bootstrapped', 80],

                ['accelerator', 70],
                ['incubator', 70],

                // Expansion

                ['unicorn', 90],

                ['angel investor', 80],

                ['private equity', 80],

                ['seed funding', 90],

                ['pre seed', 90],

                ['growth stage', 70],

                ['exit', 80],

                ['founding team', 80],

                ['business model', 80],

                ['cash flow', 80],

                ['annual recurring revenue', 90],
                ['arr', 80],

                ['monthly recurring revenue', 90],
                ['mrr', 80],

                ['customer acquisition', 80],

                ['customer retention', 80],

                ['go to market', 80],

                ['gtm', 80],

                ['scaleup', 80],

                ['scaling', 70],

                ['digital business', 70],

                ['business strategy', 80],

                ['corporate venture', 70],

                ['venture studio', 80],

                ['startup ecosystem', 80],

                ['business expansion', 70],

                ['market opportunity', 80],

                ['competitive advantage', 80],

                ['unit economics', 90],

                ['founder led', 80],

                ['startup funding', 90],
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
