@extends('layouts.dashboard')
@section('title', 'Client Dashboard — BuildHive')
@section('page_title', 'Client Dashboard')

@section('sidebar')
<a href="{{ route('client.dashboard') }}" class="sidebar-nav-item active">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
    Dashboard
</a>
<a href="{{ route('client.projects.create') }}" class="sidebar-nav-item">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Post Project
</a>
<a href="{{ route('projects.index') }}" class="sidebar-nav-item">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    Browse Projects
</a>
<a href="{{ route('freelancers.index') }}" class="sidebar-nav-item">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Find Freelancers
</a>
@endsection

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([['Total Projects', $stats['total_projects'], 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'], ['Active', $stats['active_projects'], 'M13 10V3L4 14h7v7l9-11h-7z'], ['Open', $stats['open_projects'], 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'], ['Completed', $stats['completed'], 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z']] as $s)
    <div class="glass-sm p-5 glass-hover">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400/[0.08] flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s[2] }}"/></svg>
            </div>
        </div>
        <p class="text-2xl font-heading font-bold">{{ $s[1] }}</p>
        <p class="text-xs text-text-tertiary mt-1">{{ $s[0] }}</p>
    </div>
    @endforeach
</div>

{{-- Projects List --}}
<div class="flex items-center justify-between mb-5">
    <h2 class="font-heading font-semibold text-lg">Your Projects</h2>
    <a href="{{ route('client.projects.create') }}" class="btn-primary !text-sm !py-2.5 !px-5">+ New Project</a>
</div>

@forelse($projects as $project)
<div class="glass-sm p-5 mb-4 glass-hover">
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-2">
                <h3 class="font-heading font-semibold truncate">{{ $project->title }}</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold uppercase tracking-wider
                    {{ $project->status === 'open' ? 'bg-success/10 text-success' : '' }}
                    {{ $project->status === 'in_progress' ? 'bg-amber-400/10 text-amber-400' : '' }}
                    {{ $project->status === 'completed' ? 'bg-info/10 text-info' : '' }}
                    {{ $project->status === 'review' ? 'bg-warning/10 text-warning' : '' }}
                    {{ $project->status === 'cancelled' ? 'bg-danger/10 text-danger' : '' }}
                ">{{ str_replace('_', ' ', $project->status) }}</span>
            </div>
            <p class="text-sm text-text-secondary line-clamp-1">{{ $project->description }}</p>
            <div class="flex items-center gap-4 mt-3 text-xs text-text-tertiary">
                <span>${{ number_format($project->budget) }}</span>
                <span>{{ $project->proposals_count }} proposals</span>
                <span>{{ $project->tasks_count }} tasks</span>
            </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('client.projects.manage', $project) }}" class="btn-glass !text-xs !py-2 !px-4">Manage</a>
            <a href="{{ route('client.projects.edit', $project) }}" class="w-8 h-8 rounded-lg bg-white/[0.04] border border-glass-border flex items-center justify-center text-text-tertiary hover:text-amber-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
        </div>
    </div>
</div>
@empty
<div class="glass-sm p-12 text-center">
    <p class="text-text-tertiary mb-4">You haven't created any projects yet.</p>
    <a href="{{ route('client.projects.create') }}" class="btn-primary !text-sm">Post Your First Project</a>
</div>
@endforelse
@endsection
