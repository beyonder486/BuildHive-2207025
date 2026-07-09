{{-- Glassmorphism Navbar --}}
<nav id="main-navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-out">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-3">
        <div class="glass-sm flex items-center justify-between px-6 h-16">

            {{-- Logo --}}
            <a href="/" id="logo" class="flex items-center gap-3 group">
                <div class="relative">
                    <svg viewBox="0 0 36 36" class="w-9 h-9 transition-transform duration-500 group-hover:rotate-[30deg]">
                        <defs><linearGradient id="lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                        <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#lg)"/>
                        <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="15">B</text>
                    </svg>
                    <div class="absolute inset-0 bg-amber-400/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                <span class="text-xl font-heading font-bold tracking-tight">build<span class="text-amber-400">Hive</span></span>
            </a>

            {{-- Desktop Links --}}
            <div class="hidden lg:flex items-center gap-1">
                @foreach(['Home' => '/', 'Find Talent' => '#features', 'Post a Job' => '#cta', 'Projects' => '#how-it-works', 'Messages' => '#'] as $label => $href)
                    <a href="{{ $href }}" id="nav-{{ Str::slug($label) }}" class="navbar-link {{ $label === 'Home' ? 'active-nav' : '' }}">{{ $label }}</a>
                @endforeach
            </div>

            {{-- Auth --}}
            <div class="hidden lg:flex items-center gap-3">
                <div class="flex items-center gap-2 mr-1">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-xs font-bold text-bg-primary">A</div>
                    <div>
                        <p class="text-xs font-semibold leading-none">Alex R.</p>
                        <p class="text-[10px] text-amber-400 mt-0.5">4.9 ★</p>
                    </div>
                </div>
                <a href="#" id="btn-dashboard" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300" style="background:linear-gradient(135deg,rgba(0,210,190,0.2),rgba(0,180,160,0.12));border:1px solid rgba(0,220,200,0.25);color:#5EEAD4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </a>
            </div>

            {{-- Mobile --}}
            <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white/5 text-text-secondary" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobile-menu" class="hidden lg:hidden mx-6 mb-3">
        <div class="glass-sm p-5 space-y-2">
            @foreach(['Home','Find Talent','Post a Job','Projects','Messages'] as $link)
                <a href="#" class="block px-4 py-3 text-sm text-text-secondary hover:text-amber-400 rounded-lg hover:bg-white/[0.03] transition-all">{{ $link }}</a>
            @endforeach
            <div class="h-px bg-white/5 my-3"></div>
            <a href="#" class="block px-4 py-3 text-sm font-semibold rounded-lg" style="color:#5EEAD4">Dashboard</a>
        </div>
    </div>
</nav>
