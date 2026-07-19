<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    private function gemini(string $prompt): string
    {
        try {
            $key = config('services.gemini.key');
            if (empty($key) || $key === 'your-api-key-here') {
                return $this->getMockResponse($prompt);
            }

            $response = Http::timeout(10)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$key}",
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 1024,
                    ],
                ]
            );

            if (!$response->ok()) {
                Log::error('Gemini API error', ['status' => $response->status(), 'body' => $response->body()]);
                return $this->getMockResponse($prompt);
            }

            return $response->json('candidates.0.content.parts.0.text', $this->getMockResponse($prompt));
        } catch (\Exception $e) {
            Log::error('Gemini API Exception', ['error' => $e->getMessage()]);
            return $this->getMockResponse($prompt);
        }
    }

    private function getMockResponse(string $prompt): string
    {
        if (str_contains($prompt, 'project brief')) {
            return "Develop a comprehensive platform featuring responsive user interfaces, robust backend architecture, secure authentication, and a dynamic administrative dashboard. The system will be optimized for performance, scalable for future growth, and aligned with modern industry standards.";
        }
        if (str_contains($prompt, 'team roles')) {
            return json_encode([
                ["role" => "Frontend Developer", "reason" => "Implements the user interface and responsive design.", "priority" => "essential"],
                ["role" => "Backend Engineer", "reason" => "Develops API endpoints and database logic.", "priority" => "essential"],
                ["role" => "UI/UX Designer", "reason" => "Designs the visual layout and user experience.", "priority" => "optional"],
                ["role" => "QA Specialist", "reason" => "Ensures the application is bug-free and performant.", "priority" => "optional"]
            ]);
        }
        if (str_contains($prompt, 'list of 6–10 development tasks')) {
            return json_encode([
                ["title" => "Initialize repository and set up environment", "priority" => "high"],
                ["title" => "Design database schema and run migrations", "priority" => "high"],
                ["title" => "Implement user authentication and roles", "priority" => "high"],
                ["title" => "Develop core API endpoints", "priority" => "medium"],
                ["title" => "Build frontend layout and navigation", "priority" => "medium"],
                ["title" => "Integrate payment gateway", "priority" => "low"],
                ["title" => "Conduct end-to-end testing", "priority" => "medium"]
            ]);
        }
        if (str_contains($prompt, 'professional proposal')) {
            return "Hi there,\n\nI read your project description and I'm very interested in helping you bring this to life. I have extensive experience building scalable platforms with robust backend architectures and intuitive user interfaces.\n\nMy approach would involve setting up a secure foundation, developing the core features iteratively, and ensuring the final product is both performant and aligned with your goals.\n\nI'd love to discuss the details further and get started as soon as possible.";
        }
        return "";
    }

    /**
     * POST /ai/improve-description
     * Takes a rough description and returns a professional one.
     */
    public function improveDescription(Request $request)
    {
        $request->validate(['description' => 'required|string|min:5|max:2000']);

        $prompt = <<<PROMPT
You are a professional technical project manager writing a project brief.

Rewrite the following rough project idea into a clear, professional project description (3–5 sentences). 
Use plain prose — no markdown, no bullet points, no headers. Just a well-written paragraph.

Rough idea: "{$request->description}"
PROMPT;

        try {
            $result = $this->gemini($prompt);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json(['result' => trim($result)]);
    }

    /**
     * POST /ai/generate-tasks
     * Takes a project description and returns a structured task list, then saves them.
     */
    public function generateTasks(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:5|max:2000',
            'project_id'  => 'required|exists:projects,id',
        ]);

        $prompt = <<<PROMPT
You are a senior project manager breaking down a software project into tasks.

Given this project description, generate a list of 6–10 development tasks.

Return ONLY a JSON array of objects. Each object must have:
- "title": short task name (max 60 chars)
- "priority": one of "low", "medium", "high"

Example format:
[{"title":"Set up project repository","priority":"high"},{"title":"Design database schema","priority":"high"}]

Project description: "{$request->description}"

Return only the JSON array. No explanation, no markdown.
PROMPT;
        try {
            $raw = $this->gemini($prompt);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        // Strip any markdown code fences if model adds them
        $raw = preg_replace('/```json?\s*/i', '', $raw);
        $raw = preg_replace('/```/', '', $raw);
        $tasks = json_decode(trim($raw), true);

        if (!is_array($tasks)) {
            return response()->json(['error' => 'Could not parse AI response. Please try again.'], 422);
        }

        // Save tasks to DB
        $saved = [];
        foreach ($tasks as $t) {
            if (empty($t['title'])) continue;
            $saved[] = Task::create([
                'project_id' => $request->project_id,
                'title'      => substr($t['title'], 0, 255),
                'priority'   => in_array($t['priority'] ?? '', ['low','medium','high']) ? $t['priority'] : 'medium',
                'status'     => 'todo',
            ]);
        }

        return response()->json(['tasks' => $saved, 'count' => count($saved)]);
    }

    /**
     * POST /ai/recommend-roles
     * Takes a project description and returns suggested team roles.
     */
    public function recommendRoles(Request $request)
    {
        $request->validate(['description' => 'required|string|min:5|max:2000']);

        $prompt = <<<PROMPT
You are a senior technical project manager advising on team composition.

Given this project description, recommend the ideal team roles needed to complete the project successfully.

Return ONLY a JSON array of objects. Each object must have:
- "role": job title (e.g. "Laravel Developer")
- "reason": one short sentence explaining why this role is needed (max 100 chars)
- "priority": "essential" or "optional"

Return 4–7 roles. Example format:
[{"role":"Laravel Developer","reason":"Handles backend API and database logic","priority":"essential"}]

Project description: "{$request->description}"

Return only the JSON array. No explanation, no markdown.
PROMPT;

        try {
            $raw = $this->gemini($prompt);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        $raw = preg_replace('/```json?\s*/i', '', $raw);
        $raw = preg_replace('/```/', '', $raw);
        $roles = json_decode(trim($raw), true);

        if (!is_array($roles)) {
            return response()->json(['error' => 'Could not parse AI response. Please try again.'], 422);
        }

        return response()->json(['roles' => $roles]);
    }
    /**
     * POST /ai/generate-proposal
     * Takes a project description and returns a proposal draft.
     */
    public function generateProposal(Request $request)
    {
        $request->validate(['description' => 'required|string|min:5|max:2000']);

        $prompt = <<<PROMPT
You are an expert freelancer writing a professional proposal to a client.

Write a confident, concise proposal (3-5 short paragraphs) based on this project description.
Focus on understanding their needs, proposing a brief approach, and showing enthusiasm.
Do not include generic placeholders like "[Your Name]". Start directly with "Hi there," or similar.

Project description: "{$request->description}"
PROMPT;

        try {
            $raw = $this->gemini($prompt);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        // Strip markdown if necessary, though it might be fine to keep basic formatting
        $raw = preg_replace('/```json?\s*/i', '', $raw);
        $raw = preg_replace('/```/', '', $raw);

        return response()->json(['result' => trim($raw)]);
    }
}
