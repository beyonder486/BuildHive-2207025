@extends('layouts.dashboard')
@section('title', 'Edit User — BuildHive')
@section('page_title', 'Edit User: ' . $user->name)
@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('admin.users') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z"/></svg> Users</a>
@endsection

@section('content')
<div class="max-w-lg">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-sm outline-none focus:border-amber-400/40">
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-sm outline-none focus:border-amber-400/40">
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Role</label>
            <select name="role" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-sm outline-none focus:border-amber-400/40">
                @foreach(['client','freelancer','admin'] as $r)<option value="{{ $r }}" {{ $user->role===$r?'selected':'' }}>{{ ucfirst($r) }}</option>@endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary flex-1 justify-center !py-3">Update User</button>
            <a href="{{ route('admin.users') }}" class="btn-glass flex-1 justify-center !py-3">Cancel</a>
        </div>
    </form>
</div>
@endsection
