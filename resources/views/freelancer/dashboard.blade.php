@extends('layouts.dashboard')
@section('title', 'Freelancer Dashboard — BuildHive')
@section('page_title', 'Freelancer Dashboard')
@section('sidebar')
<a href="{{ route('freelancer.dashboard') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('freelancer.profile.edit') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> My Profile</a>
<a href="{{ route('freelancer.proposals') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> My Proposals</a>
<a href="{{ route('projects.index') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Browse Projects</a>
@endsection

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([['Active Tasks',$stats['active_tasks'],'bg-amber-400/10 text-amber-400'],['Completed',$stats['completed_tasks'],'bg-success/10 text-success'],['Proposals Sent',$stats['proposals_sent'],'bg-info/10 text-info'],['Avg Rating',$stats['avg_rating'].'/5','bg-warning/10 text-warning']] as $s)
    <div class="glass-sm p-5">
        <p class="text-2xl font-heading font-bold">{{ $s[1] }}</p>
        <p class="text-xs text-text-tertiary mt-1">{{ $s[0] }}</p>
    </div>
    @endforeach
</div>

<h2 class="font-heading font-semibold text-lg mb-4">Your Tasks</h2>
@forelse($tasks->whereIn('status',['todo','in_progress']) as $task)
<div class="glass p-4 mb-3 border border-white/10 hover:border-amber-400/30 transition-colors">
    <div class="flex items-center gap-4">
        <span class="w-2.5 h-2.5 rounded-full shrink-0 {{ $task->status==='todo'?'bg-info':'bg-amber-400' }}"></span>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-text-primary">{{ $task->title }}</p>
            <p class="text-[11px] text-amber-400 mt-0.5">Project: {{ $task->project->title }}</p>
        </div>
        <div class="flex gap-2">
            @foreach(['todo','in_progress','done'] as $s)
                @if($s !== $task->status)
                <button onclick="asyncAction('/async/tasks/{{ $task->id }}/status','PATCH',{status:'{{ $s }}'}).then(()=>{showToast('Updated');location.reload()})" class="text-[10px] px-3 py-1.5 rounded-lg bg-amber-400/10 text-amber-400 hover:bg-amber-400/20 font-medium transition-colors">{{ ucfirst(str_replace('_',' ',$s)) }}</button>
                @endif
            @endforeach
        </div>
    </div>
</div>
@empty
<p class="glass-sm p-6 text-center text-text-tertiary text-sm">No active tasks. Browse projects to find work!</p>
@endforelse

<h2 class="font-heading font-semibold text-lg mt-8 mb-4">Recent Proposals</h2>
@foreach($proposals as $p)
<div class="glass-sm p-4 mb-3 flex items-center gap-4">
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium">{{ $p->project->title }}</p>
        <p class="text-[11px] text-text-tertiary">Bid: ${{ number_format($p->bid_amount) }} · {{ $p->created_at->diffForHumans() }}</p>
    </div>
    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase {{ $p->status==='pending'?'bg-warning/10 text-warning':($p->status==='accepted'?'bg-success/10 text-success':'bg-danger/10 text-danger') }}">{{ $p->status }}</span>
</div>
@endforeach
@endsection
