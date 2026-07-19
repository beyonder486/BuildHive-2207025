@extends('layouts.dashboard')
@section('title', 'Create Project — BuildHive')
@section('page_title', 'Post a New Project')
@section('sidebar')
<a href="{{ route('client.dashboard') }}" class="sidebar-nav-item">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
    Dashboard
</a>
<a href="{{ route('client.projects.create') }}" class="sidebar-nav-item active">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Post Project
</a>
@endsection

@section('content')
<div class="max-w-2xl">
    @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-danger/10 border border-danger/20 text-danger text-sm">
            @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('client.projects.store') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Project Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all" placeholder="E.g. E-commerce Platform Redesign">
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Description</label>
            <textarea name="description" rows="6" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all resize-none" placeholder="Describe the project scope, goals, and requirements...">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Budget ($)</label>
                <input type="number" name="budget" value="{{ old('budget') }}" required min="1" step="0.01" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Required Skills <span class="text-text-tertiary">(comma separated)</span></label>
            <input type="text" name="skills_required" value="{{ old('skills_required') }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all" placeholder="Laravel, Vue.js, MySQL, Tailwind CSS">
        </div>
        <button type="submit" class="btn-primary !py-3.5 w-full justify-center">Publish Project</button>
    </form>
</div>
@endsection
