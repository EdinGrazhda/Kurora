<footer class="bg-burgundy py-10 px-6">
    <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">

        <div class="flex items-center gap-2 text-light-text">
            <svg class="w-5 h-5 text-gold shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M5 16 2 6l5 4 5-7 5 7 5-4-3 10H5zm0 2h14v2H5v-2z"/>
            </svg>
            <span class="text-sm font-medium">{{ config('app.name') }}</span>
        </div>

        <p class="text-xs text-light-text/50">
            &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
        </p>

    </div>
</footer>
