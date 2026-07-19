@extends('layouts.dashboard')
@section('title', 'Manage Projects — BuildHive')
@section('page_title', 'Manage Projects')
@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('admin.users') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/></svg> Users</a>
<a href="{{ route('admin.projects') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"/></svg> Projects</a>
@endsection

@section('content')
<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-glass-border text-text-tertiary text-left">
            <th class="py-3 px-4 font-medium">Title</th><th class="py-3 px-4 font-medium">Client</th><th class="py-3 px-4 font-medium">Status</th><th class="py-3 px-4 font-medium">Budget</th><th class="py-3 px-4 font-medium">Proposals</th><th class="py-3 px-4 font-medium">Tasks</th><th class="py-3 px-4 font-medium">Actions</th>
        </tr></thead>
        <tbody>
        @foreach($projects as $p)
        <tr class="border-b border-glass-border/50 hover:bg-white/[0.02]">
            <td class="py-3 px-4 font-medium">{{ Str::limit($p->title, 30) }}</td>
            <td class="py-3 px-4 text-text-secondary">{{ $p->client->name }}</td>
            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase {{ $p->status==='open'?'bg-success/10 text-success':($p->status==='in_progress'?'bg-amber-400/10 text-amber-400':'bg-info/10 text-info') }}">{{ str_replace('_',' ',$p->status) }}</span></td>
            <td class="py-3 px-4 text-amber-400">${{ number_format($p->budget) }}</td>
            <td class="py-3 px-4 text-text-tertiary">{{ $p->proposals_count }}</td>
            <td class="py-3 px-4 text-text-tertiary">{{ $p->tasks_count }}</td>
            <td class="py-3 px-4">
                <form method="POST" action="{{ route('admin.projects.destroy', $p) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-xs text-danger hover:underline">Delete</button></form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $projects->links() }}</div>
@endsection
