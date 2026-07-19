@extends('layouts.dashboard')
@section('title', 'Proposals — ' . $project->title)
@section('page_title', 'Proposals for: ' . $project->title)
@section('sidebar')
<a href="{{ route('client.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('client.projects.proposals', $project) }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg> Proposals</a>
<a href="{{ route('client.projects.manage', $project) }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg> Tasks</a>
@endsection

@section('content')
@forelse($proposals as $p)
<div class="glass-sm p-5 mb-4 glass-hover" id="proposal-{{ $p->id }}">
    <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold shrink-0">{{ strtoupper(substr($p->freelancer->name,0,1)) }}</div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 mb-1">
                <h3 class="font-heading font-semibold">{{ $p->freelancer->name }}</h3>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase
                    {{ $p->status==='pending'?'bg-warning/10 text-warning':'' }}
                    {{ $p->status==='accepted'?'bg-success/10 text-success':'' }}
                    {{ $p->status==='rejected'?'bg-danger/10 text-danger':'' }}">{{ $p->status }}</span>
            </div>
            @if($p->freelancer->freelancerProfile)
                <div class="flex gap-2 mb-2">
                    @foreach(($p->freelancer->freelancerProfile->skills ?? []) as $skill)
                        <span class="job-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            @endif
            <p class="text-sm text-text-secondary mb-3">{{ $p->cover_letter }}</p>
            <div class="flex items-center gap-4 text-xs text-text-tertiary">
                <span>Bid: <strong class="text-amber-400">${{ number_format($p->bid_amount) }}</strong></span>
                <span>Duration: {{ $p->duration_days }} days</span>
                <span>Submitted: {{ $p->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @if($p->status === 'pending')
        <div class="flex gap-2 shrink-0">
            <button onclick="asyncAction('/async/proposals/{{ $p->id }}/status','PATCH',{status:'accepted'}).then(()=>{showToast('Proposal accepted!');location.reload()})" class="btn-primary !text-xs !py-2 !px-4">Accept</button>
            <button onclick="asyncAction('/async/proposals/{{ $p->id }}/status','PATCH',{status:'rejected'}).then(()=>{showToast('Rejected','error');location.reload()})" class="btn-glass !text-xs !py-2 !px-4">Reject</button>
        </div>
        @endif
    </div>
</div>
@empty
<div class="glass-sm p-12 text-center text-text-tertiary text-sm">No proposals received yet.</div>
@endforelse
@endsection
