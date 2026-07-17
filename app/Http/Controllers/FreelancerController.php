<?php

namespace App\Http\Controllers;

use App\Models\User;

class FreelancerController extends Controller
{
    public function index()
    {
        $freelancers = User::where('role', 'freelancer')
            ->with('freelancerProfile', 'reviewsReceived')
            ->paginate(12);
        return view('pages.freelancers.index', compact('freelancers'));
    }

    public function show(User $user)
    {
        if (!$user->isFreelancer()) abort(404);
        $user->load(['freelancerProfile', 'reviewsReceived.reviewer', 'reviewsReceived.project']);
        return view('pages.freelancers.show', compact('user'));
    }
}
