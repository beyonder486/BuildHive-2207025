@extends('layouts.app')
@section('title', 'Browse Projects — BuildHive')
@section('content')

{{-- Hero Header --}}
<div class="relative pt-28 pb-12 hex-bg">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-amber-400/[0.05] rounded-full blur-[120px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="text-center mb-10">
            <span class="glass-sm inline-block text-xs font-semibold text-amber-400 uppercase tracking-[0.2em] px-5 py-2 mb-4">Open Opportunities</span>
            <h1 class="font-heading font-[800] text-3xl md:text-5xl mb-4">Browse <span class="text-gradient">Projects</span></h1>
            <p class="text-text-secondary max-w-md mx-auto text-sm md:text-base">Discover your next opportunity across hundreds of open projects from verified clients.</p>
        </div>

        {{-- Search & Filters --}}
        <form method="GET" class="glass-sm p-3 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-3xl mx-auto">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, skill, keyword..." class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 focus:bg-amber-400/[0.02] transition-all">
            </div>
            <div class="flex items-center gap-2">
                <input type="number" name="min_budget" value="{{ request('min_budget') }}" placeholder="Min $" class="w-24 px-3 py-2.5 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
                <span class="text-text-tertiary text-xs">–</span>
                <input type="number" name="max_budget" value="{{ request('max_budget') }}" placeholder="Max $" class="w-24 px-3 py-2.5 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
                <button type="submit" class="btn-primary !text-sm !py-2.5 !px-5 whitespace-nowrap">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="divider-amber"></div>

{{-- Projects Grid --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">

    @if(request('search') || request('min_budget') || request('max_budget'))
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-text-secondary">
            Showing results
            @if(request('search')) for "<span class="text-amber-400">{{ request('search') }}</span>"@endif
        </p>
        <a href="{{ route('projects.index') }}" class="text-xs text-text-tertiary hover:text-amber-400 transition-colors flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Clear filters
        </a>
    </div>
    @endif

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($projects as $project)
        <a href="{{ route('projects.show', $project) }}" class="job-card flex flex-col group">
            {{-- Top Row --}}
            <div class="flex items-center justify-between mb-4">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold uppercase tracking-wider bg-success/10 text-success">Open</span>
                <span class="text-[11px] text-text-tertiary">{{ $project->created_at->diffForHumans() }}</span>
            </div>

            {{-- Title & Desc --}}
            <h3 class="font-heading font-semibold text-base mb-2 group-hover:text-amber-400 transition-colors leading-snug">{{ $project->title }}</h3>
            <p class="text-sm text-text-secondary line-clamp-2 mb-4 flex-1">{{ $project->description }}</p>

            {{-- Skills --}}
            @if($project->skills_required)
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach(array_slice($project->skills_required, 0, 3) as $skill)
                <span class="job-tag">{{ $skill }}</span>
                @endforeach
                @if(count($project->skills_required) > 3)
                <span class="job-tag text-text-tertiary">+{{ count($project->skills_required) - 3 }}</span>
                @endif
            </div>
            @endif

            {{-- Footer --}}
            <div class="flex items-center justify-between text-xs pt-3 border-t border-glass-border">
                <div class="flex items-center gap-3 text-text-tertiary">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg>
                        {{ $project->proposals_count }} proposals
                    </span>
                </div>
                <span class="font-heading font-bold text-amber-400 text-sm">${{ number_format($project->budget) }}</span>
            </div>

            {{-- Client info --}}
            <div class="flex items-center gap-2 mt-3 pt-3 border-t border-glass-border/50">
                <div class="w-6 h-6 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 text-[10px] font-bold">{{ strtoupper(substr($project->client->name, 0, 1)) }}</div>
                <span class="text-xs text-text-tertiary">{{ $project->client->name }}</span>
                @if($project->deadline)
                <span class="ml-auto text-[10px] text-text-tertiary">Due {{ $project->deadline->format('M d') }}</span>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="glass-sm p-16 text-center">
                <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-400/[0.08] border border-amber-400/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <p class="text-text-secondary font-medium mb-1">No projects found</p>
                <p class="text-text-tertiary text-sm">Try adjusting your filters or check back later.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($projects->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection
