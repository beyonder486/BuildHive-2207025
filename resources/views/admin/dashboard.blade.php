@extends('layouts.dashboard')
@section('title', 'Admin Dashboard — BuildHive')
@section('page_title', 'Admin Dashboard')
@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('admin.users') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg> Users</a>
<a href="{{ route('admin.projects') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg> Projects</a>
@endsection

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach([['Total Users',$stats['total_users']],['Clients',$stats['total_clients']],['Freelancers',$stats['total_freelancers']],['Total Projects',$stats['total_projects']],['Open Projects',$stats['open_projects']],['Total Proposals',$stats['total_proposals']]] as $s)
    <div class="glass-sm p-5">
        <p class="text-2xl font-heading font-bold text-gradient">{{ $s[1] }}</p>
        <p class="text-xs text-text-tertiary mt-1">{{ $s[0] }}</p>
    </div>
    @endforeach
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div>
        <h2 class="font-heading font-semibold mb-4">Recent Users</h2>
        @foreach($recentUsers as $u)
        <div class="glass-sm p-3 mb-2 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold text-xs">{{ strtoupper(substr($u->name,0,1)) }}</div>
            <div class="flex-1"><p class="text-sm font-medium">{{ $u->name }}</p><p class="text-[11px] text-text-tertiary">{{ $u->email }} · {{ $u->role }}</p></div>
            <span class="text-[10px] text-text-tertiary">{{ $u->created_at->diffForHumans() }}</span>
        </div>
        @endforeach
    </div>
    <div>
        <h2 class="font-heading font-semibold mb-4">Recent Projects</h2>
        @foreach($recentProjects as $p)
        <div class="glass-sm p-3 mb-2 flex items-center gap-3">
            <div class="flex-1"><p class="text-sm font-medium">{{ $p->title }}</p><p class="text-[11px] text-text-tertiary">by {{ $p->client->name }} · {{ $p->status }}</p></div>
            <span class="text-[10px] text-text-tertiary">${{ number_format($p->budget) }}</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
