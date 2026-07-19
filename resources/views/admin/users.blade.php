@extends('layouts.dashboard')
@section('title', 'Manage Users — BuildHive')
@section('page_title', 'Manage Users')
@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('admin.users') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg> Users</a>
<a href="{{ route('admin.projects') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2"/></svg> Projects</a>
@endsection

@section('content')
<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-glass-border text-text-tertiary text-left">
            <th class="py-3 px-4 font-medium">User</th><th class="py-3 px-4 font-medium">Email</th><th class="py-3 px-4 font-medium">Role</th><th class="py-3 px-4 font-medium">Projects</th><th class="py-3 px-4 font-medium">Proposals</th><th class="py-3 px-4 font-medium">Actions</th>
        </tr></thead>
        <tbody>
        @foreach($users as $u)
        <tr class="border-b border-glass-border/50 hover:bg-white/[0.02] transition-colors">
            <td class="py-3 px-4 font-medium">{{ $u->name }}</td>
            <td class="py-3 px-4 text-text-secondary">{{ $u->email }}</td>
            <td class="py-3 px-4"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase {{ $u->role==='admin'?'bg-danger/10 text-danger':($u->role==='client'?'bg-info/10 text-info':'bg-success/10 text-success') }}">{{ $u->role }}</span></td>
            <td class="py-3 px-4 text-text-tertiary">{{ $u->projects_count }}</td>
            <td class="py-3 px-4 text-text-tertiary">{{ $u->proposals_count }}</td>
            <td class="py-3 px-4">
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.edit', $u) }}" class="text-xs text-amber-400 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')<button class="text-xs text-danger hover:underline">Delete</button></form>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $users->links() }}</div>
@endsection
