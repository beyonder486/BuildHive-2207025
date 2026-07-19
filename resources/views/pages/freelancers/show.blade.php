@extends('layouts.app')
@section('title', $user->name . ' — BuildHive')
@section('content')
<div class="max-w-4xl mx-auto px-6 lg:px-8 pt-28 pb-16">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-text-tertiary mb-6">
        <a href="{{ route('freelancers.index') }}" class="hover:text-amber-400 transition-colors">Find Talent</a>
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-text-secondary">{{ $user->name }}</span>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Sidebar / Profile Summary --}}
        <div class="space-y-5">
            <div class="glass p-6 text-center">
                <div class="relative inline-block mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400/30 to-amber-600/10 border border-amber-400/20 flex items-center justify-center text-amber-400 font-heading font-bold text-3xl mx-auto">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full bg-success border-2 border-bg-primary"></div>
                </div>
                <h1 class="font-heading font-bold text-xl mb-1">{{ $user->name }}</h1>
                <p class="text-sm text-text-tertiary capitalize mb-4">{{ $user->freelancerProfile?->experience_level ?? 'Freelancer' }}</p>

                {{-- Rating --}}
                <div class="flex justify-center mb-4">
                    @php $rating = $user->averageRating(); @endphp
                    @if($rating)
                    <div class="glass-sm px-4 py-2 flex items-center gap-2">
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 {{ $i <= round($rating) ? 'text-amber-400' : 'text-text-tertiary/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-amber-400">{{ number_format($rating, 1) }}</span>
                    </div>
                    @else
                    <span class="text-xs text-text-tertiary">No ratings yet</span>
                    @endif
                </div>

                @if($user->freelancerProfile?->hourly_rate)
                <div class="glass-sm px-4 py-3 mb-4">
                    <p class="text-xs text-text-tertiary mb-0.5">Hourly Rate</p>
                    <p class="font-heading font-bold text-xl text-amber-400">${{ $user->freelancerProfile->hourly_rate }}<span class="text-sm font-normal text-text-tertiary">/hr</span></p>
                </div>
                @endif

                @if($user->freelancerProfile?->portfolio_url)
                <a href="{{ $user->freelancerProfile->portfolio_url }}" target="_blank" class="btn-glass !text-sm !py-2.5 w-full justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Portfolio
                </a>
                @endif
            </div>

            {{-- Back Link --}}
            <a href="{{ route('freelancers.index') }}" class="flex items-center gap-2 text-sm text-text-tertiary hover:text-amber-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Freelancers
            </a>
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- About --}}
            <div class="glass p-7">
                <h2 class="font-heading font-semibold text-lg mb-4">About</h2>
                @if($user->freelancerProfile?->bio)
                <p class="text-text-secondary leading-relaxed">{{ $user->freelancerProfile->bio }}</p>
                @else
                <p class="text-text-tertiary text-sm italic">No bio provided yet.</p>
                @endif
            </div>

            {{-- Skills --}}
            @if($user->freelancerProfile && $user->freelancerProfile->skills)
            <div class="glass p-7">
                <h2 class="font-heading font-semibold text-lg mb-4">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($user->freelancerProfile->skills as $s)
                    <span class="px-3 py-1.5 rounded-xl bg-amber-400/[0.07] border border-amber-400/[0.12] text-sm text-amber-300 font-medium">{{ $s }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            @if($user->reviewsReceived->count())
            <div class="glass p-7">
                <h2 class="font-heading font-semibold text-lg mb-5">Reviews ({{ $user->reviewsReceived->count() }})</h2>
                <div class="space-y-3">
                    @foreach($user->reviewsReceived as $r)
                    <div class="glass-sm p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 text-xs font-bold">{{ strtoupper(substr($r->reviewer->name, 0, 1)) }}</div>
                            <div>
                                <p class="text-sm font-medium">{{ $r->reviewer->name }}</p>
                                <p class="text-[11px] text-text-tertiary">on {{ $r->project->title }}</p>
                            </div>
                            <div class="ml-auto flex">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3.5 h-3.5 {{ $i <= $r->rating ? 'text-amber-400' : 'text-text-tertiary/20' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </div>
                        @if($r->comment)<p class="text-sm text-text-secondary">{{ $r->comment }}</p>@endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
