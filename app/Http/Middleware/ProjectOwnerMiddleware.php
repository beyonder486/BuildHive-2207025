<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProjectOwnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $project = $request->route('project');
        if ($project && $project->client_id !== $request->user()->id) {
            abort(403, 'You are not the owner of this project.');
        }
        return $next($request);
    }
}
