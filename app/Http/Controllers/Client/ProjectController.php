<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function create()
    {
        return view('client.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'deadline' => 'nullable|date|after:today',
            'skills_required' => 'nullable|string',
        ]);

        $skills = $data['skills_required'] ? array_map('trim', explode(',', $data['skills_required'])) : [];

        Auth::user()->projects()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'budget' => $data['budget'],
            'deadline' => $data['deadline'],
            'skills_required' => $skills,
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Project created successfully!');
    }

    public function edit(Project $project)
    {
        $this->authorizeOwner($project);
        return view('client.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorizeOwner($project);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'deadline' => 'nullable|date',
            'skills_required' => 'nullable|string',
            'status' => 'required|in:open,in_progress,review,completed,cancelled',
        ]);

        $skills = $data['skills_required'] ? array_map('trim', explode(',', $data['skills_required'])) : [];
        $project->update(array_merge($data, ['skills_required' => $skills]));

        return redirect()->route('client.projects.manage', $project)->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $this->authorizeOwner($project);
        $project->delete();
        return redirect()->route('client.dashboard')->with('success', 'Project deleted.');
    }

    public function manage(Project $project)
    {
        $this->authorizeOwner($project);
        $project->load(['proposals.freelancer', 'team.members.user', 'tasks.assignee']);
        return view('client.projects.manage', compact('project'));
    }

    public function proposals(Project $project)
    {
        $this->authorizeOwner($project);
        $proposals = $project->proposals()->with('freelancer.freelancerProfile')->latest()->get();
        return view('client.projects.proposals', compact('project', 'proposals'));
    }

    private function authorizeOwner(Project $project)
    {
        if ($project->client_id !== Auth::id()) abort(403);
    }
}
