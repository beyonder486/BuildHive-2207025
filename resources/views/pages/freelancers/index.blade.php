@extends('layouts.app')
@section('title', 'Find Freelancers — BuildHive')
@section('content')

{{-- Hero Header --}}
<div class="relative pt-28 pb-12 hex-bg">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-amber-400/[0.05] rounded-full blur-[120px] pointer-events-none"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="text-center mb-10">
            <span class="glass-sm inline-block text-xs font-semibold text-amber-400 uppercase tracking-[0.2em] px-5 py-2 mb-4">Verified Talent</span>
            <h1 class="font-heading font-[800] text-3xl md:text-5xl mb-4">Find <span class="text-gradient">Talent</span></h1>
            <p class="text-text-secondary max-w-md mx-auto text-sm md:text-base">Browse skilled freelancers ready to join your team and bring your projects to life.</p>
        </div>
    </div>
</div>

<div class="divider-amber"></div>

{{-- Freelancers Grid --}}
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($freelancers as $f)
        <a href="{{ route('freelancers.show', $f) }}" class="job-card flex flex-col group">
            {{-- Avatar & Name --}}
            <div class="flex items-center gap-4 mb-4">
                <div class="relative shrink-0">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400/30 to-amber-600/10 border border-amber-400/20 flex items-center justify-center text-amber-400 font-heading font-bold text-xl">
                        {{ strtoupper(substr($f->name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-success border-2 border-bg-primary"></div>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-heading font-semibold group-hover:text-amber-400 transition-colors truncate">{{ $f->name }}</h3>
                    <p class="text-xs text-text-tertiary capitalize mt-0.5">{{ $f->freelancerProfile?->experience_level ?? 'Freelancer' }}</p>
                </div>
                {{-- Rating --}}
                <div class="shrink-0 text-right">
                    <p class="text-amber-400 text-sm font-semibold">★ {{ $f->averageRating() ?: '—' }}</p>
                    @if($f->freelancerProfile?->hourly_rate)
                    <p class="text-[11px] text-text-tertiary">${{ $f->freelancerProfile->hourly_rate }}/hr</p>
                    @endif
                </div>
            </div>

            {{-- Bio --}}
            @if($f->freelancerProfile?->bio)
            <p class="text-sm text-text-secondary line-clamp-2 mb-4 flex-1">{{ $f->freelancerProfile->bio }}</p>
            @else
            <div class="flex-1"></div>
            @endif

            {{-- Skills --}}
            @if($f->freelancerProfile && $f->freelancerProfile->skills)
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach(array_slice($f->freelancerProfile->skills, 0, 4) as $skill)
                <span class="job-tag">{{ $skill }}</span>
                @endforeach
                @if(count($f->freelancerProfile->skills) > 4)
                <span class="job-tag text-text-tertiary">+{{ count($f->freelancerProfile->skills) - 4 }}</span>
                @endif
            </div>
            @endif

            {{-- Footer CTA --}}
            <div class="flex items-center justify-between pt-3 border-t border-glass-border text-xs text-text-tertiary">
                <span>View Profile</span>
                <svg class="w-4 h-4 text-amber-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </div>
        </a>
        @empty
        <div class="col-span-full">
            <div class="glass-sm p-16 text-center">
                <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-400/[0.08] border border-amber-400/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="text-text-secondary font-medium mb-1">No freelancers found</p>
                <p class="text-text-tertiary text-sm">Check back later as more talent joins the platform.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($freelancers->hasPages())
    <div class="mt-10 flex justify-center">
        {{ $freelancers->links() }}
    </div>
    @endif
</div>
@endsection
