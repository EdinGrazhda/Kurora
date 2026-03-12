<section id="features" class="bg-white py-24 px-6">
    <div class="max-w-5xl mx-auto">

        {{-- Section heading --}}
        <div class="text-center mb-14">
            <p class="text-xs uppercase tracking-widest text-gold mb-2">What we offer</p>
            <h2 class="text-3xl font-semibold text-dark-text">Everything for your big day</h2>
        </div>

        {{-- Cards --}}
        <div class="grid md:grid-cols-3 gap-6">

            {{-- Card 1 --}}
            <div class="flex flex-col items-center text-center p-8 bg-offwhite rounded-xl">
                <div class="inline-flex items-center justify-center w-11 h-11 bg-burgundy/10 rounded-full mb-5" aria-hidden="true">
                    <svg class="w-5 h-5 text-burgundy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-dark-text mb-2">{{ __('Plan Your Day') }}</h3>
                <p class="text-sm text-dark-text/55 leading-relaxed">
                    {{ __('Organise every detail — ceremony timeline, seating charts, and vendors — all in one place.') }}
                </p>
            </div>

            {{-- Card 2 — featured --}}
            <div class="flex flex-col items-center text-center p-8 bg-burgundy rounded-xl shadow-md">
                <div class="inline-flex items-center justify-center w-11 h-11 bg-white/10 rounded-full mb-5" aria-hidden="true">
                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-light-text mb-2">{{ __('Manage Guests') }}</h3>
                <p class="text-sm text-light-text/65 leading-relaxed">
                    {{ __('Track RSVPs, dietary requirements, and seating arrangements with ease.') }}
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="flex flex-col items-center text-center p-8 bg-offwhite rounded-xl">
                <div class="inline-flex items-center justify-center w-11 h-11 bg-burgundy/10 rounded-full mb-5" aria-hidden="true">
                    <svg class="w-5 h-5 text-burgundy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-dark-text mb-2">{{ __('Celebrate Together') }}</h3>
                <p class="text-sm text-dark-text/55 leading-relaxed">
                    {{ __('Share updates with your guests and build anticipation for the special day.') }}
                </p>
            </div>

        </div>
    </div>
</section>
