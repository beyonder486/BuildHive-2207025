<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = $user->projects()->withCount(['proposals', 'tasks'])->latest()->get();
        $stats = [
            'total_projects' => $projects->count(),
            'active_projects' => $projects->where('status', 'in_progress')->count(),
            'open_projects' => $projects->where('status', 'open')->count(),
            'completed' => $projects->where('status', 'completed')->count(),
        ];
        return view('client.dashboard', compact('projects', 'stats'));
    }
}
