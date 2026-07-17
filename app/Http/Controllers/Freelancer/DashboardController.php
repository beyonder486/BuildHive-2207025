<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->assignedTasks()->with('project')->get();
        $proposals = $user->proposals()->with('project')->latest()->take(5)->get();
        $stats = [
            'active_tasks' => $tasks->whereIn('status', ['todo', 'in_progress'])->count(),
            'completed_tasks' => $tasks->where('status', 'done')->count(),
            'proposals_sent' => $user->proposals()->count(),
            'avg_rating' => $user->averageRating(),
        ];
        return view('freelancer.dashboard', compact('tasks', 'proposals', 'stats'));
    }
}
