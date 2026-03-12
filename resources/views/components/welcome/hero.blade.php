<section class="bg-offwhite min-h-[85vh] flex items-center justify-center px-6 py-20">
    <div class="max-w-2xl mx-auto text-center">

        {{-- Decorative divider --}}
        <div class="flex items-center justify-center gap-4 mb-10" aria-hidden="true">
            <span class="w-20 h-px bg-gold/60"></span>
            <svg class="w-4 h-4 text-gold shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z"/>
            </svg>
            <span class="w-20 h-px bg-gold/60"></span>
        </div>

        <h1 class="text-5xl sm:text-6xl font-semibold text-dark-text leading-tight tracking-tight mb-6">
            Your perfect wedding,<br class="hidden sm:block"> beautifully planned
        </h1>

        <p class="text-lg text-burgundy/60 leading-relaxed mb-10 max-w-lg mx-auto">
            From the first detail to the final dance — everything you need to plan the day you've always imagined.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="w-full sm:w-auto px-8 py-3 bg-burgundy text-light-text rounded font-medium hover:bg-burgundy/90 transition-colors text-sm">
                    {{ __('Start Planning') }}
                </a>
            @endif
            <a href="#features"
               class="w-full sm:w-auto px-8 py-3 border border-burgundy/25 text-burgundy rounded font-medium hover:border-burgundy/60 transition-colors text-sm">
                {{ __('See How It Works') }}
            </a>
        </div>

    </div>
</section>
