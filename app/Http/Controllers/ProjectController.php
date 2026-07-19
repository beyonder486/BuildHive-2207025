<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('status', 'open')->with('client')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('min_budget')) {
            $query->where('budget', '>=', $request->min_budget);
        }
        if ($request->filled('max_budget')) {
            $query->where('budget', '<=', $request->max_budget);
        }
        if ($request->filled('skills')) {
            $query->where('skills_required', 'like', '%' . $request->skills . '%');
        }

        $projects = $query->paginate(12);
        return view('pages.projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['client', 'proposals.freelancer', 'team.members.user', 'tasks', 'reviews']);
        return view('pages.projects.show', compact('project'));
    }
}
