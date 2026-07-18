<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user()->freelancerProfile ?? FreelancerProfile::create(['user_id' => Auth::id()]);
        return view('freelancer.profile-edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'bio' => 'nullable|string|max:2000',
            'skills' => 'nullable|string',
            'experience_level' => 'required|in:junior,mid,senior,expert',
            'portfolio_url' => 'nullable|url|max:255',
            'hourly_rate' => 'nullable|numeric|min:1',
        ]);

        $skills = $data['skills'] ? array_map('trim', explode(',', $data['skills'])) : [];

        $profile = Auth::user()->freelancerProfile;
        $profile->update(array_merge($data, ['skills' => $skills]));

        return redirect()->route('freelancer.dashboard')->with('success', 'Profile updated!');
    }
}
