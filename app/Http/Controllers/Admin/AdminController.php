<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_freelancers' => User::where('role', 'freelancer')->count(),
            'total_projects' => Project::count(),
            'open_projects' => Project::where('status', 'open')->count(),
            'total_proposals' => Proposal::count(),
        ];
        $recentUsers = User::latest()->take(10)->get();
        $recentProjects = Project::with('client')->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentProjects'));
    }

    public function users()
    {
        $users = User::withCount(['projects', 'proposals'])->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.user-edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:client,freelancer,admin',
        ]);
        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'User updated.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted.');
    }

    public function projects()
    {
        $projects = Project::with('client')->withCount(['proposals', 'tasks'])->paginate(20);
        return view('admin.projects', compact('projects'));
    }

    public function destroyProject(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects')->with('success', 'Project deleted.');
    }
}
