{{-- Glassmorphism Navbar --}}
<nav id="main-navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-out">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-3">
        <div class="glass-sm flex items-center justify-between px-6 h-16">

            {{-- Logo --}}
            <a href="/" id="logo" class="flex items-center gap-3 group shrink-0">
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

            {{-- Desktop Nav Links --}}
            <div class="hidden lg:flex items-center gap-1 mx-auto">
                <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'active-nav' : '' }}">Home</a>
                <a href="{{ route('freelancers.index') }}" class="navbar-link {{ request()->routeIs('freelancers.*') ? 'active-nav' : '' }}">Find Talent</a>
                <a href="{{ route('projects.index') }}" class="navbar-link {{ request()->routeIs('projects.*') ? 'active-nav' : '' }}">Browse Projects</a>
            </div>

            {{-- Desktop Auth --}}
            <div class="hidden lg:flex items-center gap-3 shrink-0">
                @guest
                    <a href="{{ route('login') }}" class="text-sm font-medium text-text-secondary hover:text-amber-400 transition-colors duration-300 px-3 py-2">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary !py-2 !px-5 !text-sm">Join Now</a>
                @endguest

                @auth
                    {{-- Separator --}}
                    <div class="w-px h-6 bg-glass-border"></div>

                    {{-- User Info + Dashboard --}}
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-xs font-bold text-bg-primary ring-2 ring-amber-400/20">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="leading-tight">
                                <p class="text-xs font-semibold text-text-primary">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-amber-400 capitalize font-medium">{{ Auth::user()->role }}</p>
                            </div>
                        </div>

                        @php
                            $dashboardRoute = match(Auth::user()->role) {
                                'admin'  => route('admin.dashboard'),
                                'client' => route('client.dashboard'),
                                default  => route('freelancer.dashboard'),
                            };
                        @endphp

                        <a href="{{ $dashboardRoute }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-300 bg-amber-400/10 border border-amber-400/20 text-amber-400 hover:bg-amber-400/20 hover:border-amber-400/40">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-btn" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white/5 text-text-secondary transition-colors" aria-label="Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobile-menu" class="hidden lg:hidden mx-4 mb-3">
        <div class="glass-sm p-4 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all {{ request()->routeIs('home') ? 'text-amber-400 bg-amber-400/08 font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-white/[0.03]' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg>
                Home
            </a>
            <a href="{{ route('freelancers.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all {{ request()->routeIs('freelancers.*') ? 'text-amber-400 bg-amber-400/08 font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-white/[0.03]' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Find Talent
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm rounded-xl transition-all {{ request()->routeIs('projects.*') ? 'text-amber-400 bg-amber-400/08 font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-white/[0.03]' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Browse Projects
            </a>

            <div class="h-px bg-glass-border my-2"></div>

            @guest
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-text-secondary hover:text-text-primary rounded-xl hover:bg-white/[0.03] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In
                </a>
                <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-bg-primary font-semibold rounded-xl text-center" style="background: linear-gradient(135deg, #F5A623, #FBBF24);">
                    Join Now — It's Free
                </a>
            @endguest

            @auth
                @php
                    $dashboardRoute = match(Auth::user()->role) {
                        'admin'  => route('admin.dashboard'),
                        'client' => route('client.dashboard'),
                        default  => route('freelancer.dashboard'),
                    };
                @endphp
                <div class="px-4 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-xs font-bold text-bg-primary ring-2 ring-amber-400/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-text-primary">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-amber-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 px-4 py-3 text-sm text-amber-400 font-semibold rounded-xl bg-amber-400/10 border border-amber-400/20 transition-all hover:bg-amber-400/15">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Go to Dashboard
                </a>
            @endauth
        </div>
    </div>
</nav>
