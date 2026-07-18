<?php

namespace App\Http\Controllers\Async;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Proposal;
use App\Models\TeamMember;
use App\Models\Team;
use App\Models\Notification;
use App\Models\Review;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsyncController extends Controller
{
    /** PATCH /async/tasks/{task}/status */
    public function updateTaskStatus(Request $request, Task $task)
    {
        $request->validate(['status' => 'required|in:todo,in_progress,done']);
        $task->update(['status' => $request->status]);
        return response()->json(['success' => true, 'status' => $task->status]);
    }

    /** PATCH /async/proposals/{proposal}/status */
    public function updateProposalStatus(Request $request, Proposal $proposal)
    {
        $request->validate(['status' => 'required|in:accepted,rejected']);
        $project = $proposal->project;

        if ($project->client_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $proposal->update(['status' => $request->status]);

        if ($request->status === 'accepted') {
            // Create team if not exists
            $team = $project->team ?? Team::create([
                'project_id' => $project->id,
                'name' => $project->title . ' Team',
            ]);
            TeamMember::create([
                'team_id' => $team->id,
                'user_id' => $proposal->freelancer_id,
                'role_in_team' => 'developer',
                'approval_status' => 'approved',
            ]);
            $project->update(['status' => 'in_progress']);
        }

        Notification::create([
            'user_id' => $proposal->freelancer_id,
            'type' => 'proposal_' . $request->status,
            'message' => 'Your proposal for "' . $project->title . '" was ' . $request->status,
            'url' => route('projects.show', $project),
        ]);

        return response()->json(['success' => true, 'status' => $proposal->status]);
    }

    /** PATCH /async/team-members/{member}/status */
    public function updateTeamMemberStatus(Request $request, TeamMember $member)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $member->update(['approval_status' => $request->status]);

        Notification::create([
            'user_id' => $member->user_id,
            'type' => 'team_' . $request->status,
            'message' => 'Your team membership was ' . $request->status,
        ]);

        return response()->json(['success' => true]);
    }

    /** GET /async/notifications/unread */
    public function unreadNotifications()
    {
        $notifications = Auth::user()->notifications()
            ->where('is_read', false)
            ->latest()
            ->take(10)
            ->get();
        return response()->json([
            'count' => $notifications->count(),
            'items' => $notifications,
        ]);
    }

    /** PATCH /async/notifications/{id}/read */
    public function markNotificationRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    /** POST /async/reviews */
    public function storeReview(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'reviewee_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::create(array_merge($data, ['reviewer_id' => Auth::id()]));
        return response()->json(['success' => true, 'review' => $review]);
    }

    /** POST /async/tasks */
    public function storeTask(Request $request)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::create($data);
        $task->load('assignee');
        return response()->json(['success' => true, 'task' => $task]);
    }

    /** DELETE /async/tasks/{task} */
    public function destroyTask(Task $task)
    {
        $task->delete();
        return response()->json(['success' => true]);
    }

    /** GET /async/search/projects */
    public function searchProjects(Request $request)
    {
        $projects = Project::where('status', 'open')
            ->where('title', 'like', '%' . $request->q . '%')
            ->with('client')
            ->take(10)
            ->get();
        return response()->json($projects);
    }
}
