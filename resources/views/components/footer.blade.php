{{-- Footer --}}
<footer class="relative border-t border-glass-border bg-bg-secondary/40">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div>
                <a href="/" class="flex items-center gap-3 mb-5">
                    <svg viewBox="0 0 36 36" class="w-8 h-8">
                        <defs><linearGradient id="fg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#FBBF24"/><stop offset="100%" stop-color="#F5A623"/></linearGradient></defs>
                        <polygon points="18,1 33,9.5 33,26.5 18,35 3,26.5 3,9.5" fill="url(#fg)"/>
                        <text x="18" y="23" text-anchor="middle" fill="#07080D" font-family="Outfit" font-weight="800" font-size="14">B</text>
                    </svg>
                    <span class="text-lg font-heading font-bold">Build<span class="text-amber-400">Hive</span></span>
                </a>
                <p class="text-sm text-text-tertiary leading-relaxed mb-6">A collaborative freelance marketplace where teams are built and projects thrive.</p>
                <div class="flex gap-3">
                    @foreach(['M23 3a10.9 10.9 0 0 0-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z','M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z','M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22'] as $p)
                    <a href="#" class="w-9 h-9 glass-sm flex items-center justify-center text-text-tertiary hover:text-amber-400 hover:border-amber-400/20 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $p }}"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>
            @foreach(['Platform' => ['Browse Projects','Find Freelancers','Post a Project','How It Works'], 'Company' => ['About Us','Careers','Blog','Contact'], 'Support' => ['Help Center','Terms of Service','Privacy Policy','Trust & Safety']] as $h => $links)
            <div>
                <h4 class="font-heading font-semibold text-xs uppercase tracking-[0.2em] text-text-secondary mb-5">{{ $h }}</h4>
                <ul class="space-y-3">
                    @foreach($links as $l)
                    <li><a href="#" class="text-sm text-text-tertiary hover:text-amber-400 transition-colors duration-300">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <div class="py-6 border-t border-glass-border flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-text-tertiary">&copy; {{ date('Y') }} BuildHive. All rights reserved.</p>
            <p class="text-xs text-text-tertiary">Built with 🍯 for freelancers, by freelancers.</p>
        </div>
    </div>
</footer>
