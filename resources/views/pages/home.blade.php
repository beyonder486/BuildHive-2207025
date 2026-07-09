@extends('layouts.app')
@section('title', 'BuildHive — Build Teams. Build Projects. Build Futures.')
@section('content')

{{-- HERO --}}
<section id="hero" class="relative min-h-screen flex items-center overflow-hidden">
    <div class="absolute top-[15%] left-[20%] w-[500px] h-[500px] bg-amber-400/[0.07] rounded-full blur-[120px] animate-glow-pulse pointer-events-none"></div>
    <div class="absolute bottom-[10%] right-[15%] w-[400px] h-[400px] bg-amber-500/[0.05] rounded-full blur-[100px] animate-glow-pulse pointer-events-none" style="animation-delay:2s"></div>
    <div class="absolute inset-0 pointer-events-none">
        <svg class="absolute top-24 right-[18%] w-14 h-14 text-amber-400/[0.08] animate-float" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>
        <svg class="absolute top-[55%] left-[8%] w-8 h-8 text-amber-400/[0.06] animate-float-slow" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>
        <svg class="absolute bottom-[20%] left-[35%] w-6 h-6 text-amber-400/[0.07] animate-float-slow" style="animation-delay:1s" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 pt-32 pb-24 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left: Copy --}}
            <div>
                <div class="glass-sm inline-flex items-center gap-2.5 px-5 py-2.5 mb-8 opacity-0 animate-fade-up">
                    <span class="relative flex h-2.5 w-2.5"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-400"></span></span>
                    <span class="text-xs font-semibold text-amber-400 uppercase tracking-[0.2em]">For Builders, By Builders</span>
                </div>
                <h1 class="font-heading font-[900] text-[3.5rem] md:text-[4.5rem] lg:text-[5.5rem] leading-[1.02] mb-7 opacity-0 animate-fade-up" data-delay="1">
                    Build<br>The<br><span class="text-gradient">Future</span>
                </h1>
                <p class="text-lg md:text-xl text-text-secondary leading-relaxed max-w-lg mb-10 opacity-0 animate-fade-up" data-delay="2">
                    A collaborative freelance marketplace with verified talent, team-based delivery, and <span class="text-amber-400 font-semibold">zero hidden fees</span>.
                </p>
                <div class="flex flex-wrap items-center gap-4 opacity-0 animate-fade-up" data-delay="3">
                    <a href="#" class="btn-primary !text-base !py-4 !px-9">
                        Get Started
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="#how-it-works" class="btn-glass !text-base !py-4 !px-9">Browse Projects</a>
                </div>
            </div>

            {{-- Right: Dashboard Mockup --}}
            <div class="hidden lg:block opacity-0 animate-fade-up" data-delay="4">
                <div class="relative">
                    <div class="absolute -inset-4 bg-gradient-to-br from-amber-400/[0.08] via-transparent to-amber-500/[0.05] rounded-3xl blur-xl"></div>
                    <div class="relative glass overflow-hidden" style="border-radius:20px;">
                        {{-- Browser chrome --}}
                        <div class="flex items-center gap-2 px-4 py-3 border-b border-white/[0.06]" style="background:rgba(10,12,18,0.8)">
                            <div class="w-3 h-3 rounded-full bg-[#FF5F57]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#FEBC2E]"></div>
                            <div class="w-3 h-3 rounded-full bg-[#28C840]"></div>
                            <span class="ml-3 text-[11px] text-text-tertiary font-mono flex-1 text-center">buildHive.com/dashboard</span>
                        </div>
                        {{-- Mini navbar inside mockup --}}
                        <div class="flex items-center justify-between px-4 py-2.5 border-b border-white/[0.04]" style="background:rgba(10,12,18,0.6)">
                            <span class="font-heading font-bold text-sm">build<span class="text-amber-400">Hive</span></span>
                            <div class="flex items-center gap-3 text-[10px] text-text-tertiary">
                                <span class="text-amber-400">Home</span><span>Find Talent</span><span>Post a Job</span><span>Projects</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-[9px] font-bold text-bg-primary">A</div>
                                <span class="text-[10px] px-2 py-1 rounded-lg font-semibold" style="background:rgba(0,200,180,0.2);color:#5EEAD4">Dashboard</span>
                            </div>
                        </div>
                        {{-- Dashboard body --}}
                        <div class="flex" style="height:340px">
                            {{-- Sidebar --}}
                            <div class="w-32 shrink-0 border-r border-white/[0.04] p-3 flex flex-col gap-1" style="background:rgba(8,10,16,0.5)">
                                <div class="flex items-center gap-1.5 px-2 py-2 rounded-lg text-[10px] font-semibold text-text-primary" style="background:rgba(255,255,255,0.05)">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                    Dashboard
                                </div>
                                @foreach(['Explore Jobs','My Contracts','Earnings','Settings','glass cards'] as $item)
                                <div class="px-2 py-1.5 rounded-lg text-[10px] text-text-tertiary">{{ $item }}</div>
                                @endforeach
                            </div>
                            {{-- Main --}}
                            <div class="flex-1 p-4 overflow-hidden" style="background:rgba(8,10,16,0.3)">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-xs font-semibold">Welcome back, <span class="text-amber-400">Alex!</span> 🐝</p>
                                    <div class="flex items-center gap-3 text-[9px] text-text-tertiary">
                                        <span>Total Earnings <span class="text-text-primary font-semibold">$24.8k</span></span>
                                        <span>Hours Billed <span class="text-text-primary font-semibold">120h</span></span>
                                        <span>Contracts <span class="text-text-primary font-semibold">4</span></span>
                                    </div>
                                </div>
                                <p class="text-[10px] text-text-tertiary mb-2">Active Projects (4)</p>
                                {{-- Mini job cards --}}
                                <div class="grid grid-cols-3 gap-2 mb-3">
                                    @foreach([['Frontend React Developer','React · UI/UX · Remote','$95k–$120k/yr',4],['Product Designer','UI/UX','$110k/yr',5],['UX Researcher','Remote','$80/hr',3]] as $j)
                                    <div class="rounded-xl p-2.5" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07)">
                                        <p class="text-[9px] font-semibold text-text-primary mb-1 leading-snug">{{ $j[0] }}</p>
                                        <p class="text-[8px] text-text-tertiary mb-2">{{ $j[1] }}</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-[9px] font-bold text-text-primary">{{ $j[2] }}</p>
                                            <span class="text-[8px] px-1.5 py-0.5 rounded-md font-semibold text-bg-primary" style="background:linear-gradient(135deg,#F5A623,#FBBF24)">Apply</span>
                                        </div>
                                        <div class="mt-1.5 pt-1.5 border-t border-white/[0.05] flex justify-between items-center">
                                            <span class="text-[7px] text-text-tertiary">{{ $j[3] }} applicants</span>
                                            <div class="flex">@for($s=0;$s<5;$s++)<svg class="w-2 h-2 {{ $s<$j[3] ? 'text-amber-400' : 'text-text-tertiary/30' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                {{-- Recent Opportunities --}}
                                <p class="text-[10px] text-text-tertiary mb-2">Recent Opportunities</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['$24.8k','120h','4'] as $v)
                                    <div class="rounded-xl p-2" style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06)">
                                        <p class="text-[10px] font-bold text-text-primary">{{ $v }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="mt-24 grid grid-cols-2 md:grid-cols-4 gap-4 reveal">
            @foreach([['2K+','Freelancers'],['500+','Open Projects'],['98%','Client Satisfaction'],['$0','Sign-up Fees']] as $i => $s)
            <div class="glass text-center py-7 px-5 glass-hover" data-delay="{{ $i + 1 }}">
                <p class="text-3xl md:text-4xl font-heading font-bold text-gradient">{{ $s[0] }}</p>
                <p class="text-xs text-text-tertiary mt-2 uppercase tracking-wider">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="divider-amber"></div>

{{-- HOW IT WORKS --}}
<section id="how-it-works" class="relative py-28 hex-bg">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-20 reveal">
            <span class="glass-sm inline-block text-xs font-semibold text-amber-400 uppercase tracking-[0.2em] px-5 py-2 mb-5">How It Works</span>
            <h2 class="font-heading font-[800] text-3xl md:text-5xl mb-5">From Idea to <span class="text-gradient">Delivery</span></h2>
            <p class="text-text-secondary max-w-xl mx-auto">Four simple steps to transform your project from concept to a fully delivered product.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['M12 4v16m8-8H4','Post a Project','Define scope, budget, and required skills.','01'],
                ['M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z','Find Talent','Review proposals from verified freelancers.','02'],
                ['M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197','Build a Team','Assemble teams with defined roles.','03'],
                ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','Deliver & Review','Track milestones, get rated on completion.','04'],
            ] as $i => $step)
            <div class="glass p-8 text-center glass-hover group reveal relative" data-delay="{{ $i + 1 }}">
                <span class="absolute top-5 right-5 text-[11px] font-mono text-text-tertiary/30 font-bold">{{ $step[3] }}</span>
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-amber-400/[0.08] border border-amber-400/[0.1] flex items-center justify-center group-hover:bg-amber-400/[0.15] transition-all duration-500">
                    <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="{{ $step[0] }}"/></svg>
                </div>
                <h3 class="font-heading font-semibold text-lg mb-3">{{ $step[1] }}</h3>
                <p class="text-sm text-text-secondary leading-relaxed">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="divider-amber"></div>

{{-- FEATURES --}}
<section id="features" class="relative py-28">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-20 reveal">
            <span class="glass-sm inline-block text-xs font-semibold text-amber-400 uppercase tracking-[0.2em] px-5 py-2 mb-5">Features</span>
            <h2 class="font-heading font-[800] text-3xl md:text-5xl mb-5">Everything You Need to <span class="text-gradient">Thrive</span></h2>
            <p class="text-text-secondary max-w-xl mx-auto">Powerful tools for seamless collaboration between clients and freelance teams.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2','Project Lifecycle','Manage projects through stages — proposed, in progress, review, completed.'],
                ['M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2','Task Management','Kanban boards with priorities, assignees, and drag-drop tracking.'],
                ['M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197','Team Collaboration','Role-based teams with client approval workflow built in.'],
                ['M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z','Ratings & Reviews','Build trust with verified ratings for every completed project.'],
                ['M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9','Smart Notifications','Real-time alerts for proposals, tasks, and milestones.'],
                ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','Analytics Dashboard','Rich dashboards for clients and freelancers to track everything.'],
            ] as $i => $f)
            <div class="glass p-7 glass-hover group reveal" data-delay="{{ ($i % 3) + 1 }}">
                <div class="w-12 h-12 rounded-xl bg-amber-400/[0.08] border border-amber-400/[0.08] flex items-center justify-center mb-5 group-hover:bg-amber-400/[0.15] transition-all duration-500">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path d="{{ $f[0] }}"/></svg>
                </div>
                <h3 class="font-heading font-semibold text-lg mb-2.5">{{ $f[1] }}</h3>
                <p class="text-sm text-text-secondary leading-relaxed">{{ $f[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<div class="divider-amber"></div>

{{-- CTA --}}
<section id="cta" class="relative py-32 overflow-hidden">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-amber-400/[0.06] rounded-full blur-[150px]"></div>
    </div>
    <div class="max-w-3xl mx-auto px-6 lg:px-8 text-center relative">
        <div class="glass p-12 md:p-16 reveal">
            <h2 class="font-heading font-[800] text-3xl md:text-5xl mb-6">Ready to <span class="text-gradient">Build</span>?</h2>
            <p class="text-lg text-text-secondary max-w-xl mx-auto mb-10">Join thousands already collaborating on BuildHive. Start your first project in minutes.</p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="#" class="btn-primary !text-lg !py-4 !px-10">
                    Start Building Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
                <a href="#" class="btn-glass !text-lg !py-4 !px-10">View Demo</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); }
        });
    });
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    menuBtn?.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); } });
    }, { threshold: 0.15 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
});
</script>
@endpush
