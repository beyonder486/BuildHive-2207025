@extends('layouts.dashboard')
@section('title', 'Edit Project — BuildHive')
@section('page_title', 'Edit Project')
@section('sidebar')
<a href="{{ route('client.dashboard') }}" class="sidebar-nav-item">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1"/></svg>
    Dashboard
</a>
@endsection

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('client.projects.update', $project) }}" class="space-y-6">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Project Title</label>
            <input type="text" name="title" value="{{ old('title', $project->title) }}" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Description</label>
            <textarea name="description" rows="6" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all resize-none">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Budget ($)</label>
                <input type="number" name="budget" value="{{ old('budget', $project->budget) }}" required class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Status</label>
                <select name="status" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
                    @foreach(['open','in_progress','review','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ $project->status===$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Required Skills</label>
            <input type="text" name="skills_required" value="{{ old('skills_required', is_array($project->skills_required) ? implode(', ', $project->skills_required) : '') }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary !py-3 flex-1 justify-center">Update Project</button>
            <a href="{{ route('client.dashboard') }}" class="btn-glass !py-3 flex-1 justify-center">Cancel</a>
        </div>
    </form>
    <form method="POST" action="{{ route('client.projects.destroy', $project) }}" class="mt-6" onsubmit="return confirm('Delete this project?')">
        @csrf @method('DELETE')
        <button type="submit" class="text-sm text-danger hover:underline">Delete this project</button>
    </form>
</div>
@endsection
