@extends('layouts.dashboard')
@section('title', 'My Proposals — BuildHive')
@section('page_title', 'My Proposals')
@section('sidebar')
<a href="{{ route('freelancer.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('freelancer.profile.edit') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> My Profile</a>
<a href="{{ route('freelancer.proposals') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> My Proposals</a>
@endsection

@section('content')
@forelse($proposals as $p)
<div class="glass-sm p-5 mb-4 glass-hover">
    <div class="flex items-start justify-between gap-4">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('projects.show', $p->project) }}" class="font-heading font-semibold hover:text-amber-400 transition-colors">{{ $p->project->title }}</a>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase {{ $p->status==='pending'?'bg-warning/10 text-warning':($p->status==='accepted'?'bg-success/10 text-success':'bg-danger/10 text-danger') }}">{{ $p->status }}</span>
            </div>
            <p class="text-sm text-text-secondary line-clamp-2 mb-2">{{ $p->cover_letter }}</p>
            <div class="flex gap-4 text-xs text-text-tertiary">
                <span>Bid: <strong class="text-amber-400">${{ number_format($p->bid_amount) }}</strong></span>
                <span>{{ $p->duration_days }} days</span>
                <span>By {{ $p->project->client->name }}</span>
                <span>{{ $p->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @if($p->status === 'pending')
        <form method="POST" action="{{ route('freelancer.proposals.destroy', $p) }}" onsubmit="return confirm('Withdraw this proposal?')">
            @csrf @method('DELETE')
            <button class="text-xs text-danger/60 hover:text-danger transition-colors">Withdraw</button>
        </form>
        @endif
    </div>
</div>
@empty
<div class="glass-sm p-12 text-center"><p class="text-text-tertiary text-sm mb-4">You haven't submitted any proposals yet.</p><a href="{{ route('projects.index') }}" class="btn-primary !text-sm">Browse Projects</a></div>
@endforelse
@endsection
