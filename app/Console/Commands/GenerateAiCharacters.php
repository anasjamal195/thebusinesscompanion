<?php

namespace App\Console\Commands;

use App\Models\AiCharacter;
use App\Services\OpenRouterService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

#[Signature('app:generate-ai-characters {--force : Re-generate existing characters}')]
#[Description('Generate AI character profiles + FAL Flux Schnell avatars for each occupation')]
class GenerateAiCharacters extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(OpenRouterService $ai): int
    {
        $occupations = ['Founder', 'Engineer', 'Marketer', 'Researcher', 'Sales', 'HR', 'Consultant', 'Analyst'];
        $force = (bool) $this->option('force');

        $this->info('Wiping out previous characters...');
        AiCharacter::truncate();

        $this->info('Generating 3 characters per occupation...');

        foreach ($occupations as $occupation) {
            for ($i = 1; $i <= 3; $i++) {
                $key = Str::slug($occupation) . '-' . $i;

                [$name, $tagline, $bio, $systemPrompt, $avatarPrompt] = $this->buildCharacter($occupation, $i);

                $this->line("Generating {$key}: {$name}");

                $avatarUrl = null;
                try {
                    $avatarUrl = $ai->generateImage($avatarPrompt);
                } catch (\Throwable $e) {
                    $this->warn("Avatar generation failed for {$key}: " . $e->getMessage());
                }

                AiCharacter::create([
                    'key' => $key,
                    'occupation' => $occupation,
                    'name' => $name,
                    'tagline' => $tagline,
                    'bio' => $bio,
                    'system_prompt' => $systemPrompt,
                    'avatar_url' => $avatarUrl,
                    'monthly_price' => rand(4, 19) + 0.99, // dynamic pricing example
                    'is_premium' => true,
                    'meta' => [
                        'variant' => $i,
                        'avatar_prompt' => $avatarPrompt,
                    ],
                ]);
            }
        }

        $this->info('Done.');
        return self::SUCCESS;
    }

    private function buildCharacter(string $occupation, int $variant): array
    {
        $baseStyle = "Professional premium SaaS assistant. Practical, specific, action-driven. Uses short sections and checklists. No fluff.";

        $variants = [
            1 => ['style' => 'Direct and structured', 'visual' => 'A natural, friendly, candid portrait of an American person, very realistic, casual everyday clothing, relaxed environment setting like a cozy cafe, soft natural daylight, iPhone photography aesthetic, unedited look'],
            2 => ['style' => 'Warm and coaching', 'visual' => 'A warm, approachable, natural candid portrait of an American person smiling, very realistic, standing in a bright modern home office, candid smile, everyday look, soft authentic lighting'],
            3 => ['style' => 'Analytical and strategic', 'visual' => 'A calm, intelligent, natural portrait of an American person, very realistic, casual sweater or simple attire, sitting at a wooden desk with plants, soft afternoon sunlight, highly authentic human look'],
        ];
        $v = $variants[$variant] ?? $variants[1];

        $namePool = [
            'Founder' => ['Michael', 'Sarah', 'James'],
            'Engineer' => ['David', 'Emily', 'Christopher'],
            'Marketer' => ['Jessica', 'Matthew', 'Ashley'],
            'Researcher' => ['Robert', 'Amanda', 'Joshua'],
            'Sales' => ['Brandon', 'Megan', 'Justin'],
            'HR' => ['Rachel', 'Tyler', 'Lauren'],
            'Consultant' => ['William', 'Olivia', 'Jonathan'],
            'Analyst' => ['Kevin', 'Nicole', 'Ryan'],
        ];
        $names = $namePool[$occupation] ?? ['Alex', 'Morgan', 'Taylor'];
        $name = $names[$variant - 1] ?? $names[0];

        $tagline = match ($occupation) {
            'Founder' => 'Your strategic partner in scaling and executing complex business visions.',
            'Engineer' => 'Expert systems design, scalable architecture, and technical problem solving.',
            'Marketer' => 'Master of growth loops, brand positioning, and high-conversion funnels.',
            'Researcher' => 'Deep market analysis, evidence-based synthesis, and trend forecasting.',
            'Sales' => 'Closing strategies, pipeline management, and client psychological profiles.',
            'HR' => 'Talent acquisition strategy, culture building, and conflict resolution.',
            'Consultant' => 'High-level operational audits and strategic workflow optimization.',
            'Analyst' => 'Data-driven insights, financial modeling, and metric analysis.',
            default => 'Dedicated professional expert ready to assist your workflows.',
        };

        $bio = "{$name} brings years of top-tier experience to the table as your dedicated {$occupation}. Known for a {$v['style']} approach, {$name} helps you cut through the noise, structure your daily execution, and achieve predictable, high-quality outcomes. Forget the busywork—{$name} handles the execution while you focus on the vision.";

        $occupationSpecialty = match ($occupation) {
            'Founder' => "You specialize in product strategy, prioritization, GTM planning, and executive-level summaries.",
            'Engineer' => "You specialize in architecture, implementation plans, debugging, and technical writing.",
            'Marketer' => "You specialize in positioning, messaging, campaigns, content calendars, and conversion copy.",
            'Researcher' => "You specialize in research plans, frameworks, summaries, and careful reasoning under uncertainty.",
            'Sales' => "You specialize in outreach templates, objection handling, pitch scripts, and CRM pipeline logic.",
            'HR' => "You specialize in drafting job descriptions, onboarding plans, employee handbooks, and performance revs.",
            'Consultant' => "You specialize in creating audit reports, action plans, process diagrams, and change management strategies.",
            'Analyst' => "You specialize in interpreting raw data, forecasting models, outlining SQL queries, and KPI reporting.",
            default => "You specialize in turning inputs into actionable outputs.",
        };

        $systemPrompt = trim(<<<PROMPT
You are The Business Companion AI, an expert assistant for a {$occupation}.
Persona: {$name}. Tone: {$v['style']}. {$baseStyle}

{$occupationSpecialty}

Rules:
- Ask at most 2 clarifying questions if required; otherwise proceed.
- Output must be plain text. Use headings like: Summary, Plan, Steps, Risks, Metrics.
- Be specific: include examples, checklists, and decision criteria.
- Avoid generic advice. Prefer concrete next actions.
PROMPT);

        $avatarPrompt = trim(<<<PROMPT
{$v['visual']}, business attire, high-end SaaS brand feel, no distortion, beautiful composition, realistic texture
PROMPT);

        return [$name, $tagline, $bio, $systemPrompt, $avatarPrompt];
    }
}
