<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FreelancerProfile;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Task;
use App\Models\Review;
use App\Models\Notification;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create(['name' => 'Admin', 'email' => 'admin@buildhive.io', 'password' => Hash::make('password'), 'role' => 'admin']);

        // Clients
        $clients = [];
        foreach ([
            ['Sarah Mitchell', 'sarah@example.com'],
            ['David Chen', 'david@example.com'],
            ['Emily Rogers', 'emily@example.com'],
        ] as $c) {
            $clients[] = User::create(['name' => $c[0], 'email' => $c[1], 'password' => Hash::make('password'), 'role' => 'client']);
        }

        // Freelancers
        $freelancers = [];
        $freelancerData = [
            ['Alex Kumar', 'alex@example.com', ['Laravel', 'PHP', 'MySQL', 'Vue.js'], 'senior', 45],
            ['Priya Sharma', 'priya@example.com', ['React', 'Node.js', 'TypeScript', 'MongoDB'], 'mid', 35],
            ['James Wilson', 'james@example.com', ['Python', 'Django', 'PostgreSQL', 'Docker'], 'expert', 60],
            ['Maria Garcia', 'maria@example.com', ['Figma', 'UI/UX', 'Tailwind CSS', 'HTML'], 'senior', 40],
            ['Omar Hassan', 'omar@example.com', ['Flutter', 'Dart', 'Firebase', 'REST API'], 'mid', 30],
        ];
        foreach ($freelancerData as $f) {
            $user = User::create(['name' => $f[0], 'email' => $f[1], 'password' => Hash::make('password'), 'role' => 'freelancer']);
            FreelancerProfile::create([
                'user_id' => $user->id, 'bio' => $f[0] . ' is an experienced ' . $f[3] . ' developer.',
                'skills' => $f[2], 'experience_level' => $f[3], 'hourly_rate' => $f[4],
            ]);
            $freelancers[] = $user;
        }

        // Projects
        $projectsData = [
            [$clients[0], 'E-commerce Platform Redesign', 'Complete redesign of our e-commerce platform with modern UI, improved checkout flow, and mobile responsiveness.', 5000, ['Laravel', 'Vue.js', 'Tailwind CSS'], 'in_progress'],
            [$clients[0], 'Mobile Banking App', 'Build a secure mobile banking app with biometric authentication and real-time transaction tracking.', 12000, ['Flutter', 'Firebase', 'REST API'], 'open'],
            [$clients[1], 'AI Content Generator', 'Develop an AI-powered content generation tool with GPT integration and a user-friendly dashboard.', 8000, ['Python', 'React', 'OpenAI API'], 'open'],
            [$clients[1], 'Healthcare Portal', 'Patient management system with appointment scheduling, medical records, and telemedicine features.', 15000, ['Laravel', 'MySQL', 'Vue.js'], 'in_progress'],
            [$clients[2], 'Social Media Analytics', 'Dashboard for tracking social media metrics across multiple platforms with data visualization.', 6000, ['React', 'Node.js', 'D3.js'], 'open'],
            [$clients[2], 'Restaurant Ordering System', 'Online ordering system with real-time kitchen display, delivery tracking, and payment integration.', 4000, ['Laravel', 'Tailwind CSS', 'Stripe'], 'completed'],
        ];

        $projects = [];
        foreach ($projectsData as $p) {
            $projects[] = Project::create([
                'client_id' => $p[0]->id, 'title' => $p[1], 'description' => $p[2],
                'budget' => $p[3], 'skills_required' => $p[4], 'status' => $p[5],
                'deadline' => now()->addDays(rand(14, 90)),
            ]);
        }

        // Proposals
        foreach ([$projects[0], $projects[2], $projects[4]] as $proj) {
            foreach (array_slice($freelancers, 0, 3) as $fl) {
                Proposal::create([
                    'project_id' => $proj->id, 'freelancer_id' => $fl->id,
                    'cover_letter' => 'I am highly interested in this project and have relevant experience in the required technologies.',
                    'bid_amount' => $proj->budget * (rand(70, 100) / 100), 'duration_days' => rand(14, 60),
                    'status' => $proj === $projects[0] && $fl === $freelancers[0] ? 'accepted' : 'pending',
                ]);
            }
        }

        // Teams & Members for in-progress projects
        foreach ([$projects[0], $projects[3]] as $proj) {
            $team = Team::create(['project_id' => $proj->id, 'name' => $proj->title . ' Team']);
            TeamMember::create(['team_id' => $team->id, 'user_id' => $freelancers[0]->id, 'role_in_team' => 'developer', 'approval_status' => 'approved']);
            TeamMember::create(['team_id' => $team->id, 'user_id' => $freelancers[3]->id, 'role_in_team' => 'designer', 'approval_status' => 'approved']);
            TeamMember::create(['team_id' => $team->id, 'user_id' => $freelancers[1]->id, 'role_in_team' => 'tester', 'approval_status' => 'pending']);
        }

        // Tasks
        $taskNames = ['Setup project structure', 'Design database schema', 'Build authentication', 'Create API endpoints', 'Implement UI components', 'Write unit tests', 'Deploy to staging', 'Performance optimization'];
        foreach ([$projects[0], $projects[3], $projects[5]] as $proj) {
            foreach (array_slice($taskNames, 0, rand(4, 8)) as $i => $t) {
                Task::create([
                    'project_id' => $proj->id,
                    'assigned_to' => $freelancers[array_rand($freelancers)]->id,
                    'title' => $t, 'description' => 'Task details for: ' . $t,
                    'status' => ['todo', 'in_progress', 'done'][min($i, 2)],
                    'priority' => ['low', 'medium', 'high'][rand(0, 2)],
                    'due_date' => now()->addDays(rand(3, 30)),
                ]);
            }
        }

        // Reviews for completed project
        Review::create(['project_id' => $projects[5]->id, 'reviewer_id' => $clients[2]->id, 'reviewee_id' => $freelancers[0]->id, 'rating' => 5, 'comment' => 'Excellent work! Delivered on time with great quality.']);
        Review::create(['project_id' => $projects[5]->id, 'reviewer_id' => $freelancers[0]->id, 'reviewee_id' => $clients[2]->id, 'rating' => 4, 'comment' => 'Great client, clear requirements and quick responses.']);

        // Notifications
        Notification::create(['user_id' => $clients[0]->id, 'type' => 'proposal', 'message' => 'Alex Kumar submitted a proposal for "E-commerce Platform Redesign"', 'url' => '/client/projects/1/proposals']);
        Notification::create(['user_id' => $freelancers[0]->id, 'type' => 'proposal_accepted', 'message' => 'Your proposal for "E-commerce Platform Redesign" was accepted!', 'url' => '/projects/1']);
    }
}
