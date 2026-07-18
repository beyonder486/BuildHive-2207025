@extends('layouts.app')
@section('title', 'Sign In — BuildHive')
@section('hide_chrome')@endsection
@section('content')
<style>
.auth-input {
    width: 100%;
    padding: 11px 14px;
    border-radius: 12px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    color: #EEEEF3;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    outline: none;
    transition: border-color 0.25s, background 0.25s;
    box-sizing: border-box;
}
.auth-input:focus {
    border-color: rgba(245,166,35,0.5);
    background: rgba(245,166,35,0.03);
}
.auth-input::placeholder { color: #555B6E; }
.auth-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #8A90A3;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.auth-btn-primary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px 20px;
    background: linear-gradient(135deg, #F5A623, #FBBF24);
    color: #07080D;
    font-weight: 700;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
}
.auth-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(245,166,35,0.3);
}
.auth-btn-glass {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 11px 20px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    color: #EEEEF3;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    border-radius: 12px;
    cursor: pointer;
    transition: background 0.25s, border-color 0.25s;
    text-decoration: none;
    box-sizing: border-box;
}
.auth-btn-glass:hover {
    background: rgba(245,166,35,0.07);
    border-color: rgba(245,166,35,0.25);
}
.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 18px 0;
}
.auth-divider::before, .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,0.07);
}
.auth-divider span { font-size: 12px; color: #555B6E; }
</style>

<div style="display:flex;min-height:100vh;">

    {{-- ── Left Decorative Panel ── --}}
    <div class="hex-bg" style="display:none;flex-direction:column;justify-content:space-between;width:44%;padding:48px;position:relative;overflow:hidden;flex-shrink:0;" id="login-left-panel">
        <div style="position:absolute;top:20%;left:20%;width:400px;height:400px;background:rgba(245,166,35,0.07);border-radius:50%;filter:blur(100px);pointer-events:none;"></div>
        <div style="position:absolute;bottom:10%;right:5%;width:260px;height:260px;background:rgba(245,166,35,0.05);border-radius:50%;filter:blur(80px);pointer-events:none;"></div>
        <svg style="position:absolute;top:80px;right:60px;width:48px;height:48px;color:rgba(245,166,35,0.08);" class="animate-float" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>
        <svg style="position:absolute;bottom:120px;left:40px;width:28px;height:28px;color:rgba(245,166,35,0.06);" class="animate-float-slow" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>

        {{-- Logo --}}
        <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;position:relative;z-index:1;">
            <svg viewBox="0 0 36 36" style="width:38px;height:38px;flex-shrink:0;">
                <defs><linearGradient id="lp-lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#lp-lg)"/>
                <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="15">B</text>
            </svg>
            <span style="font-family:'Outfit',sans-serif;font-size:1.35rem;font-weight:800;color:#EEEEF3;">build<span style="color:#F5A623;">Hive</span></span>
        </a>

        {{-- Tagline --}}
        <div style="position:relative;z-index:1;">
            <h2 style="font-family:'Outfit',sans-serif;font-size:2.6rem;font-weight:900;line-height:1.1;margin:0 0 16px;">
                Welcome<br>Back to<br><span class="text-gradient">the Hive</span>
            </h2>
            <p style="color:#8A90A3;font-size:14px;line-height:1.7;margin:0 0 32px;max-width:280px;">Your projects, proposals, and team are waiting for you.</p>

            <div style="display:flex;flex-direction:column;gap:14px;">
                @foreach([
                    ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z','Role-based access for clients & freelancers'],
                    ['M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','Team collaboration with approval workflows'],
                    ['M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9','Real-time task tracking & notifications'],
                ] as $feat)
                <div style="display:flex;align-items:center;gap:12px;">
                    <div class="glass-sm" style="width:34px;height:34px;min-width:34px;display:flex;align-items:center;justify-content:center;border-radius:10px;">
                        <svg style="width:16px;height:16px;color:#F5A623;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $feat[0] }}"/></svg>
                    </div>
                    <p style="font-size:13px;color:#8A90A3;margin:0;">{{ $feat[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Testimonial --}}
        <div class="glass-sm" style="padding:20px;position:relative;z-index:1;">
            <p style="font-size:13px;color:#8A90A3;line-height:1.65;margin:0 0 12px;">"BuildHive made it incredibly easy to find the right freelancers and manage our entire project."</p>
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#F5A623,#FBBF24);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#07080D;flex-shrink:0;">S</div>
                <div>
                    <p style="font-size:12px;font-weight:600;margin:0;color:#EEEEF3;">Sarah K.</p>
                    <p style="font-size:11px;color:#555B6E;margin:0;">Product Manager, TechCorp</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right Form Panel ── --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;background:var(--color-bg-primary);position:relative;">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:500px;height:500px;background:rgba(245,166,35,0.03);border-radius:50%;filter:blur(100px);pointer-events:none;"></div>

        <div style="width:100%;max-width:400px;position:relative;">

            <a href="/" class="auth-right-logo" style="display:flex;align-items:center;gap:10px;margin-bottom:36px;text-decoration:none;">
                <svg viewBox="0 0 36 36" style="width:30px;height:30px;flex-shrink:0;">
                    <defs><linearGradient id="fp-lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                    <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#fp-lg)"/>
                    <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="15">B</text>
                </svg>
                <span style="font-family:'Outfit',sans-serif;font-size:1.15rem;font-weight:800;color:#EEEEF3;">build<span style="color:#F5A623;">Hive</span></span>
            </a>

            <h1 style="font-family:'Outfit',sans-serif;font-size:1.9rem;font-weight:800;margin:0 0 6px;color:#EEEEF3;">Sign In</h1>
            <p style="color:#8A90A3;font-size:14px;margin:0 0 28px;">No account? <a href="{{ route('register') }}" style="color:#F5A623;font-weight:600;text-decoration:none;">Sign up free →</a></p>

            @if($errors->any())
            <div style="margin-bottom:20px;padding:12px 16px;border-radius:12px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);color:#F87171;font-size:13px;">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:16px;">
                @csrf

                <div>
                    <label class="auth-label">Email Address</label>
                    <input class="auth-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">
                </div>

                <div>
                    <label class="auth-label">Password</label>
                    <input class="auth-input" type="password" name="password" required autocomplete="current-password" placeholder="Your password">
                </div>

                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="remember" style="width:15px;height:15px;accent-color:#F5A623;cursor:pointer;flex-shrink:0;">
                    <span style="font-size:13px;color:#8A90A3;">Remember me</span>
                </label>

                <button type="submit" class="auth-btn-primary" style="margin-top:4px;">
                    Sign In
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <div class="auth-divider"><span>or</span></div>

            <a href="{{ route('register') }}" class="auth-btn-glass">Create a Free Account</a>
        </div>
    </div>
</div>

<style>
@media (min-width: 1024px) {
    #login-left-panel { display: flex !important; }
    .auth-right-logo { display: none !important; }
}
</style>
@endsection
