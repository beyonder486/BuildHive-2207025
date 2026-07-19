@extends('layouts.dashboard')
@section('title', 'Manage: ' . $project->title)
@section('page_title', 'Manage: ' . $project->title)
@section('sidebar')
<a href="{{ route('client.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('client.projects.proposals', $project) }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/></svg> Proposals</a>
<a href="{{ route('client.projects.manage', $project) }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg> Tasks</a>
@endsection

@section('content')
<h2 class="font-heading font-semibold mb-4">Team</h2>
@if($project->team && $project->team->members->count())
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-8">
    @foreach($project->team->members as $m)
    <div class="glass-sm p-4 flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 font-bold text-sm">{{ strtoupper(substr($m->user->name,0,1)) }}</div>
        <div class="flex-1"><p class="text-sm font-medium">{{ $m->user->name }}</p><p class="text-[11px] text-text-tertiary capitalize">{{ $m->role_in_team }} · {{ $m->approval_status }}</p></div>
        @if($m->approval_status==='pending')
        <button onclick="asyncAction('/async/team-members/{{ $m->id }}/status','PATCH',{status:'approved'}).then(()=>location.reload())" class="text-[10px] px-2 py-1 rounded bg-success/10 text-success">✓</button>
        <button onclick="asyncAction('/async/team-members/{{ $m->id }}/status','PATCH',{status:'rejected'}).then(()=>location.reload())" class="text-[10px] px-2 py-1 rounded bg-danger/10 text-danger">✗</button>
        @endif
    </div>
    @endforeach
</div>
@else
<p class="glass-sm p-6 text-center text-text-tertiary text-sm mb-8">No team yet. Accept proposals to build one.</p>
@endif

<div class="flex items-center justify-between mb-4">
    <h2 class="font-heading font-semibold">Tasks</h2>
    <button onclick="document.getElementById('tf').classList.toggle('hidden')" class="btn-primary !text-xs !py-2 !px-4">+ Add Task</button>
</div>
<div id="tf" class="hidden glass-sm p-5 mb-6">
    <input id="nt" type="text" placeholder="Task title" class="w-full px-4 py-2.5 rounded-xl bg-white/[0.04] border border-glass-border text-sm outline-none focus:border-amber-400/40 mb-3">
    <select id="np" class="w-full px-4 py-2.5 rounded-xl bg-white/[0.04] border border-glass-border text-sm outline-none mb-3"><option value="low">Low</option><option value="medium" selected>Medium</option><option value="high">High</option></select>
    <button onclick="asyncAction('/async/tasks','POST',{project_id:{{ $project->id }},title:nt.value,priority:np.value}).then(()=>{showToast('Created');location.reload()})" class="btn-primary !text-sm !py-2">Create</button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
@foreach(['todo'=>'To Do','in_progress'=>'In Progress','done'=>'Done'] as $st=>$lb)
<div>
    <h3 class="text-sm font-semibold text-text-secondary mb-3"><span class="inline-block w-2 h-2 rounded-full mr-2 {{ $st==='todo'?'bg-info':($st==='in_progress'?'bg-amber-400':'bg-success') }}"></span>{{ $lb }}</h3>
    @foreach($project->tasks->where('status',$st) as $t)
    <div class="glass-sm p-3 mb-2">
        <p class="text-sm font-medium">{{ $t->title }}</p>
        @if($t->assignee)<p class="text-[11px] text-text-tertiary">→ {{ $t->assignee->name }}</p>@endif
        <div class="flex gap-1 mt-2">
            @foreach(['todo','in_progress','done'] as $s)
                @if($s!==$t->status)
                <button onclick="asyncAction('/async/tasks/{{ $t->id }}/status','PATCH',{status:'{{ $s }}'}).then(()=>location.reload())" class="text-[10px] px-2 py-1 rounded bg-white/[0.04] text-text-tertiary hover:text-amber-400">{{ ucfirst(str_replace('_',' ',$s)) }}</button>
                @endif
            @endforeach
            <button onclick="if(confirm('Delete?'))asyncAction('/async/tasks/{{ $t->id }}','DELETE').then(()=>location.reload())" class="text-[10px] px-2 py-1 rounded text-danger/50 hover:text-danger ml-auto">Del</button>
        </div>
    </div>
    @endforeach
</div>
@endforeach
</div>
@endsection
