<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    public function index()
    {
        $proposals = Auth::user()->proposals()->with('project.client')->latest()->get();
        return view('freelancer.proposals', compact('proposals'));
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'cover_letter' => 'required|string|max:3000',
            'bid_amount' => 'required|numeric|min:1',
            'duration_days' => 'required|integer|min:1',
        ]);

        if ($project->proposals()->where('freelancer_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already submitted a proposal.');
        }

        $project->proposals()->create(array_merge($data, ['freelancer_id' => Auth::id()]));

        Notification::create([
            'user_id' => $project->client_id,
            'type' => 'proposal',
            'message' => Auth::user()->name . ' submitted a proposal for "' . $project->title . '"',
            'url' => route('client.projects.proposals', $project),
        ]);

        return redirect()->route('freelancer.proposals')->with('success', 'Proposal submitted!');
    }

    public function destroy(Proposal $proposal)
    {
        if ($proposal->freelancer_id !== Auth::id()) abort(403);
        $proposal->delete();
        return back()->with('success', 'Proposal withdrawn.');
    }
}
