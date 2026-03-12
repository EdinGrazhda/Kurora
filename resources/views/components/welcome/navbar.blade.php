<header x-data="{ open: false }" class="sticky top-0 z-50 bg-burgundy shadow-sm">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2.5 text-light-text">
            <svg class="w-6 h-6 text-gold shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M5 16 2 6l5 4 5-7 5 7 5-4-3 10H5zm0 2h14v2H5v-2z"/>
            </svg>
            <span class="text-base font-semibold tracking-wide">{{ config('app.name') }}</span>
        </a>

        {{-- Desktop nav --}}
        @if (Route::has('login'))
            <nav class="hidden sm:flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-1.5 text-sm text-light-text border border-gold/30 rounded hover:bg-gold/10 transition-colors">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-1.5 text-sm text-light-text hover:text-gold transition-colors">
                        {{ __('Sign In') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-1.5 text-sm bg-gold text-dark-text rounded font-medium hover:bg-gold/90 transition-colors">
                            {{ __('Get Started') }}
                        </a>
                    @endif
                @endauth
            </nav>

            {{-- Mobile hamburger --}}
            <button @click="open = !open"
                    class="sm:hidden text-light-text p-1.5 rounded hover:bg-gold/10 transition-colors"
                    :aria-expanded="open"
                    aria-label="{{ __('Toggle menu') }}">
                <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>

    {{-- Mobile menu --}}
    @if (Route::has('login'))
        <div x-show="open"
             x-transition:enter="transition duration-150"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="sm:hidden border-t border-gold/20 px-6 py-4 flex flex-col gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="text-sm text-light-text border border-gold/30 rounded px-4 py-2 text-center hover:bg-gold/10 transition-colors">
                    {{ __('Dashboard') }}
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-sm text-light-text text-center py-2 hover:text-gold transition-colors">
                    {{ __('Sign In') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="text-sm bg-gold text-dark-text rounded font-medium px-4 py-2 text-center hover:bg-gold/90 transition-colors">
                        {{ __('Get Started') }}
                    </a>
                @endif
            @endauth
        </div>
    @endif
</header>
