@extends('layouts.app')
@section('title', 'Create Account — BuildHive')
@section('hide_chrome')@endsection
@section('content')
<style>
.role-card {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 18px 12px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.02);
    cursor: pointer;
    transition: border-color 0.25s, background 0.25s;
    text-align: center;
}
.role-card:hover {
    border-color: rgba(245,166,35,0.3);
    background: rgba(245,166,35,0.03);
}
.role-card input[type=radio] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.role-card.selected {
    border-color: rgba(245,166,35,0.6);
    background: rgba(245,166,35,0.07);
}
.role-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(245,166,35,0.08);
    border: 1px solid rgba(245,166,35,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div style="display:flex;min-height:100vh;">

    {{-- ── Left Decorative Panel ── --}}
    <div class="hex-bg" style="display:none;flex-direction:column;justify-content:space-between;width:44%;padding:48px;position:relative;overflow:hidden;flex-shrink:0;" id="reg-left-panel">
        <div style="position:absolute;top:20%;left:20%;width:400px;height:400px;background:rgba(245,166,35,0.07);border-radius:50%;filter:blur(100px);pointer-events:none;"></div>
        <div style="position:absolute;bottom:10%;right:5%;width:250px;height:250px;background:rgba(245,166,35,0.05);border-radius:50%;filter:blur(80px);pointer-events:none;"></div>
        <svg style="position:absolute;top:80px;right:60px;width:48px;height:48px;color:rgba(245,166,35,0.08);" class="animate-float" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>
        <svg style="position:absolute;top:55%;left:30px;width:24px;height:24px;color:rgba(245,166,35,0.06);" class="animate-float-slow" viewBox="0 0 40 40"><polygon points="20,2 36,11 36,29 20,38 4,29 4,11" fill="currentColor"/></svg>

        {{-- Logo --}}
        <a href="/" style="display:flex;align-items:center;gap:12px;text-decoration:none;position:relative;z-index:1;">
            <svg viewBox="0 0 36 36" style="width:38px;height:38px;flex-shrink:0;">
                <defs><linearGradient id="rp-lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#rp-lg)"/>
                <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="15">B</text>
            </svg>
            <span style="font-family:'Outfit',sans-serif;font-size:1.35rem;font-weight:800;color:#EEEEF3;">build<span style="color:#F5A623;">Hive</span></span>
        </a>

        {{-- Tagline --}}
        <div style="position:relative;z-index:1;">
            <h2 style="font-family:'Outfit',sans-serif;font-size:2.6rem;font-weight:900;line-height:1.1;margin:0 0 16px;">
                Start Building<br>Something<br><span class="text-gradient">Great</span>
            </h2>
            <p style="color:#8A90A3;font-size:14px;line-height:1.7;margin:0 0 32px;max-width:280px;">Join thousands of clients and freelancers already collaborating on BuildHive.</p>

            <div style="display:flex;flex-direction:column;gap:16px;">
                @foreach([['01','Create your free account in seconds'],['02','Post a project or build your freelancer profile'],['03','Start collaborating and building great work']] as $step)
                <div style="display:flex;align-items:center;gap:14px;">
                    <div class="glass-sm" style="width:34px;height:34px;min-width:34px;display:flex;align-items:center;justify-content:center;border-radius:10px;">
                        <span style="font-size:11px;font-weight:700;font-family:'JetBrains Mono',monospace;color:#F5A623;">{{ $step[0] }}</span>
                    </div>
                    <p style="font-size:13px;color:#8A90A3;margin:0;">{{ $step[1] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Stats --}}
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;position:relative;z-index:1;">
            @foreach([['2K+','Freelancers'],['500+','Projects'],['$0','Sign-up Fee']] as $s)
            <div class="glass-sm" style="padding:16px 10px;text-align:center;">
                <p class="text-gradient" style="font-family:'Outfit',sans-serif;font-weight:800;font-size:1.2rem;margin:0;">{{ $s[0] }}</p>
                <p style="font-size:11px;color:#555B6E;margin:4px 0 0;">{{ $s[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Right Form Panel ── --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px;background:var(--color-bg-primary);position:relative;overflow-y:auto;">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:500px;height:500px;background:rgba(245,166,35,0.03);border-radius:50%;filter:blur(100px);pointer-events:none;"></div>

        <div style="width:100%;max-width:400px;position:relative;">

            {{-- Logo --}}
            <a href="/" class="auth-right-logo" style="display:flex;align-items:center;gap:10px;margin-bottom:32px;text-decoration:none;">
                <svg viewBox="0 0 36 36" style="width:30px;height:30px;flex-shrink:0;">
                    <defs><linearGradient id="fp2-lg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                    <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#fp2-lg)"/>
                    <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="15">B</text>
                </svg>
                <span style="font-family:'Outfit',sans-serif;font-size:1.15rem;font-weight:800;color:#EEEEF3;">build<span style="color:#F5A623;">Hive</span></span>
            </a>

            <h1 style="font-family:'Outfit',sans-serif;font-size:1.9rem;font-weight:800;margin:0 0 6px;color:#EEEEF3;">Create Account</h1>
            <p style="color:#8A90A3;font-size:14px;margin:0 0 28px;">Already have one? <a href="{{ route('login') }}" style="color:#F5A623;font-weight:600;text-decoration:none;">Sign in →</a></p>

            @if($errors->any())
            <div style="margin-bottom:18px;padding:12px 16px;border-radius:12px;background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.2);color:#F87171;font-size:13px;display:flex;flex-direction:column;gap:4px;">
                @foreach($errors->all() as $e)<p style="margin:0;">{{ $e }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;" id="reg-form">
                @csrf

                <div>
                    <label class="form-label">Full Name</label>
                    <input class="form-input" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="John Doe">
                </div>

                <div>
                    <label class="form-label">Email Address</label>
                    <input class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@example.com">
                </div>

                {{-- Role Selector --}}
                <div>
                    <label class="form-label" style="margin-bottom:10px;">I want to</label>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                        <label class="role-card {{ old('role','client') === 'client' ? 'selected' : '' }}" id="card-client" onclick="selectRole('client')">
                            <input type="radio" name="role" value="client" {{ old('role','client')==='client' ? 'checked' : '' }} id="role-client">
                            <div class="role-card-icon">
                                <svg style="width:20px;height:20px;color:#F5A623;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#EEEEF3;margin:0 0 2px;">Hire Talent</p>
                                <p style="font-size:11px;color:#555B6E;margin:0;">I'm a client</p>
                            </div>
                        </label>

                        <label class="role-card {{ old('role') === 'freelancer' ? 'selected' : '' }}" id="card-freelancer" onclick="selectRole('freelancer')">
                            <input type="radio" name="role" value="freelancer" {{ old('role')==='freelancer' ? 'checked' : '' }} id="role-freelancer">
                            <div class="role-card-icon">
                                <svg style="width:20px;height:20px;color:#F5A623;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:600;color:#EEEEF3;margin:0 0 2px;">Find Work</p>
                                <p style="font-size:11px;color:#555B6E;margin:0;">I'm a freelancer</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="form-label">Password</label>
                    <input class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters">
                </div>

                <div>
                    <label class="form-label">Confirm Password</label>
                    <input class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password">
                </div>

                <button type="submit" class="btn-primary w-full justify-center !py-3" style="margin-top:4px;">
                    Create My Account
                    <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>

                <p style="text-align:center;font-size:12px;color:#555B6E;margin:0;">
                    By signing up you agree to our
                    <a href="#" style="color:rgba(245,166,35,0.8);text-decoration:none;">Terms</a>
                    &amp;
                    <a href="#" style="color:rgba(245,166,35,0.8);text-decoration:none;">Privacy Policy</a>.
                </p>
            </form>
        </div>
    </div>
</div>

<style>
@media (min-width: 1024px) {
    #reg-left-panel { display: flex !important; }
    .auth-right-logo { display: none !important; }
}
</style>

@push('scripts')
<script>
function selectRole(role) {
    document.getElementById('role-client').checked = (role === 'client');
    document.getElementById('role-freelancer').checked = (role === 'freelancer');
    document.getElementById('card-client').classList.toggle('selected', role === 'client');
    document.getElementById('card-freelancer').classList.toggle('selected', role === 'freelancer');
}
// Init on load in case of old() value
document.addEventListener('DOMContentLoaded', function() {
    var checked = document.querySelector('input[name=role]:checked');
    if (checked) selectRole(checked.value);
});
</script>
@endpush
@endsection
