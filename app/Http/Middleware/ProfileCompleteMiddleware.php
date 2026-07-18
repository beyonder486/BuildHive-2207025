<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileCompleteMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user && $user->isFreelancer() && !$user->freelancerProfile) {
            return redirect()->route('freelancer.profile.edit')
                ->with('warning', 'Please complete your profile before submitting proposals.');
        }
        return $next($request);
    }
}
