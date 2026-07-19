<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BuildHive Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Kanban board custom scrollbar */
        .board-scroll { scrollbar-width: thin; scrollbar-color: rgba(245,166,35,0.15) transparent; }
        .board-scroll::-webkit-scrollbar { height: 6px; }
        .board-scroll::-webkit-scrollbar-track { background: transparent; }
        .board-scroll::-webkit-scrollbar-thumb { background: rgba(245,166,35,0.2); border-radius: 99px; }

        /* Kanban column lanes */
        .kanban-col { min-width: 280px; max-width: 280px; }
        .kanban-col-todo    { border-top: 3px solid rgba(96,165,250,0.5); }
        .kanban-col-in_progress { border-top: 3px solid rgba(245,166,35,0.7); }
        .kanban-col-review  { border-top: 3px solid rgba(168,85,247,0.6); }
        .kanban-col-done    { border-top: 3px solid rgba(52,211,153,0.5); }

        /* Task cards */
        .task-card {
            background: rgba(20, 23, 31, 0.9);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 14px;
            transition: all 0.2s ease;
            cursor: default;
            position: relative;
        }
        .task-card:hover {
            border-color: rgba(245,166,35,0.35);
            background: rgba(25, 28, 38, 0.95);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3), 0 0 0 1px rgba(245,166,35,0.08);
            transform: translateY(-2px);
        }
        .task-card .delete-btn {
            opacity: 0;
            transition: opacity 0.2s;
        }
        .task-card:hover .delete-btn { opacity: 1; }

        /* Priority pill */
        .priority-high   { background: rgba(248,113,113,0.12); color: #F87171; border: 1px solid rgba(248,113,113,0.2); }
        .priority-medium { background: rgba(251,191,36,0.12);  color: #FBBF24; border: 1px solid rgba(251,191,36,0.2); }
        .priority-low    { background: rgba(96,165,250,0.12);  color: #60A5FA; border: 1px solid rgba(96,165,250,0.2); }

        /* Status select inside card */
        .status-pill {
            appearance: none;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: var(--color-text-secondary);
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
        }
        .status-pill:hover { border-color: rgba(245,166,35,0.4); color: #F5A623; }

        /* Modal overlay */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px); z-index: 100;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-box {
            background: #0D0F16; border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 28px; width: 100%; max-width: 440px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="min-h-screen bg-[#07080D] text-text-primary antialiased relative">

    {{-- Ambient glows --}}
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-15%] left-[-10%] w-[700px] h-[700px] bg-amber-400/[0.025] rounded-full blur-[140px]"></div>
        <div class="absolute bottom-[-15%] right-[-10%] w-[600px] h-[600px] bg-amber-500/[0.015] rounded-full blur-[120px]"></div>
    </div>

    <div class="flex h-screen overflow-hidden relative z-10">

        {{-- ─── Sidebar ─── --}}
        <aside style="background: rgba(10,12,18,0.85); border-right: 1px solid rgba(255,255,255,0.06);" class="w-[220px] shrink-0 backdrop-blur-xl flex flex-col">

            {{-- Logo --}}
            <div class="px-5 py-[18px]" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                <a href="/" class="flex items-center gap-3">
                    <div style="background: linear-gradient(135deg, #FBBF24, #F5A623); border-radius: 10px; padding: 6px; display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 16px rgba(245,166,35,0.3);">
                        <svg viewBox="0 0 20 20" class="w-5 h-5" fill="#07080D">
                            <polygon points="10,1 18,5.5 18,14.5 10,19 2,14.5 2,5.5"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-[15px] font-heading font-bold leading-none">Build<span style="color: #F5A623;">Hive</span></span>
                        <p class="text-[10px] mt-0.5" style="color: rgba(138,144,163,0.7); font-weight:500;">Marketplace</p>
                    </div>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto dashboard-scroll">
                <p class="text-[9px] font-bold uppercase tracking-widest px-3 mb-2" style="color: rgba(85,91,110,0.8);">Navigation</p>
                @yield('sidebar')
            </nav>

            {{-- User footer --}}
            <div class="px-3 py-3" style="border-top: 1px solid rgba(255,255,255,0.05);">
                <div class="flex items-center gap-3 px-3 py-2 rounded-xl" style="background: rgba(255,255,255,0.03);">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm shrink-0"
                         style="background: linear-gradient(135deg, rgba(245,166,35,0.25), rgba(245,166,35,0.1)); color: #F5A623; font-family: 'Outfit', sans-serif;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold truncate" style="color: #EEEEF3;">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] capitalize" style="color: #555B6E;">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="p-1 rounded-lg transition-colors" style="color: #555B6E;" onmouseover="this.style.color='#F87171'" onmouseout="this.style.color='#555B6E'" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ─── Main content ─── --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Top bar --}}
            <header class="h-14 shrink-0 flex items-center justify-between px-6" style="background: rgba(7,8,13,0.85); border-bottom: 1px solid rgba(255,255,255,0.05); backdrop-filter: blur(20px);">
                <div class="flex items-center gap-3">
                    {{-- Breadcrumb / Page Title --}}
                    <h1 class="font-heading font-semibold text-[15px]" style="color: #EEEEF3;">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Notification Bell --}}
                    <div class="relative">
                        <button id="notif-btn" onclick="document.getElementById('notif-panel').classList.toggle('hidden')"
                                class="relative w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200"
                                style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07); color: #8A90A3;"
                                onmouseover="this.style.background='rgba(245,166,35,0.08)'; this.style.borderColor='rgba(245,166,35,0.25)'; this.style.color='#F5A623';"
                                onmouseout="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(255,255,255,0.07)'; this.style.color='#8A90A3';">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span id="notif-badge" class="absolute -top-1 -right-1 w-4 h-4 rounded-full text-[9px] font-bold flex items-center justify-center"
                                  style="background: #F5A623; color: #07080D; display:none; box-shadow: 0 0 8px rgba(245,166,35,0.6);"></span>
                        </button>

                        {{-- Notification panel --}}
                        <div id="notif-panel" class="hidden absolute right-0 top-12 z-50"
                             style="width: 380px; background: #0D0F16; border: 1px solid rgba(245,166,35,0.15); border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); overflow: hidden;">
                            <div class="flex items-center justify-between px-5 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full" style="background: #F5A623;"></div>
                                    <h3 class="font-heading font-semibold text-sm">Notifications</h3>
                                </div>
                                <button class="text-[10px] font-semibold uppercase tracking-wider transition-colors" style="color: #F5A623;" onmouseover="this.style.color='#FBBF24'" onmouseout="this.style.color='#F5A623'">Mark all read</button>
                            </div>
                            <div id="notif-dropdown" class="max-h-[380px] overflow-y-auto dashboard-scroll">
                                <div class="px-5 py-10 text-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-3" style="background: rgba(255,255,255,0.03); color: #555B6E;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                    </div>
                                    <p class="text-xs font-medium" style="color: #555B6E;">All caught up! No new notifications.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 overflow-y-auto dashboard-scroll" style="padding: 20px 24px; background: transparent;">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background: rgba(52,211,153,0.08); border: 1px solid rgba(52,211,153,0.2); color: #34D399;">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background: rgba(248,113,113,0.08); border: 1px solid rgba(248,113,113,0.2); color: #F87171;">{{ session('error') }}</div>
                @endif
                @if(session('warning'))
                    <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background: rgba(251,191,36,0.08); border: 1px solid rgba(251,191,36,0.2); color: #FBBF24;">{{ session('warning') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
