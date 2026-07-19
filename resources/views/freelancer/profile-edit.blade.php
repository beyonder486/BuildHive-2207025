@extends('layouts.dashboard')
@section('title', 'Edit Profile — BuildHive')
@section('page_title', 'Edit Your Profile')
@section('sidebar')
<a href="{{ route('freelancer.dashboard') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h-2"/></svg> Dashboard</a>
<a href="{{ route('freelancer.profile.edit') }}" class="sidebar-nav-item active"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> My Profile</a>
<a href="{{ route('freelancer.proposals') }}" class="sidebar-nav-item"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> My Proposals</a>
@endsection

@section('content')
<div class="max-w-2xl">
    @if($errors->any())
        <div class="mb-4 px-4 py-3 rounded-xl bg-danger/10 border border-danger/20 text-danger text-sm">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif
    <form method="POST" action="{{ route('freelancer.profile.update') }}" class="space-y-6">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Bio</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all resize-none" placeholder="Tell clients about yourself...">{{ old('bio', $profile->bio) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Skills <span class="text-text-tertiary">(comma separated)</span></label>
            <input type="text" name="skills" value="{{ old('skills', is_array($profile->skills) ? implode(', ', $profile->skills) : '') }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all" placeholder="Laravel, React, MySQL">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Experience Level</label>
                <select name="experience_level" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
                    @foreach(['junior','mid','senior','expert'] as $lv)
                    <option value="{{ $lv }}" {{ $profile->experience_level===$lv?'selected':'' }}>{{ ucfirst($lv) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-text-secondary mb-2">Hourly Rate ($)</label>
                <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $profile->hourly_rate) }}" min="1" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-secondary mb-2">Portfolio URL</label>
            <input type="url" name="portfolio_url" value="{{ old('portfolio_url', $profile->portfolio_url) }}" class="w-full px-4 py-3 rounded-xl bg-white/[0.04] border border-glass-border text-text-primary text-sm outline-none focus:border-amber-400/40 transition-all" placeholder="https://yourportfolio.com">
        </div>
        <button type="submit" class="btn-primary !py-3.5 w-full justify-center">Save Profile</button>
    </form>
</div>
@endsection
