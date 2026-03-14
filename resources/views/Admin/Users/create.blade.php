<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.users.index') }}" wire:navigate.hover>{{ __('Users') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Create') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20">
                <flux:icon name="user-plus" class="size-5 text-emerald-500" />
            </div>
            <div>
                <flux:heading size="lg">{{ __('Create User') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ __('Add a new user account to the system.') }}</flux:text>
            </div>
        </div>

        {{-- Form card --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
            <form wire:submit="save" class="divide-y divide-zinc-200 dark:divide-zinc-700">

                {{-- Account details --}}
                <div class="p-6 space-y-5">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ __('Account Details') }}</flux:text>

                    <flux:input
                        wire:model="name"
                        :label="__('Name')"
                        placeholder="{{ __('Full name') }}"
                        required
                    />

                    <flux:input
                        wire:model="email"
                        type="email"
                        :label="__('Email')"
                        placeholder="{{ __('user@example.com') }}"
                        required
                    />
                </div>

                {{-- Password section --}}
                <div class="p-6 space-y-5">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ __('Security') }}</flux:text>

                    <flux:input
                        wire:model="password"
                        type="password"
                        :label="__('Password')"
                        placeholder="{{ __('Minimum 8 characters') }}"
                        required
                    />

                    <flux:input
                        wire:model="password_confirmation"
                        type="password"
                        :label="__('Confirm Password')"
                        placeholder="{{ __('Repeat password') }}"
                        required
                    />
                </div>

                {{-- Role selection --}}
                @if ($allRoles->isNotEmpty())
                    <div class="p-6">
                        <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">{{ __('Roles') }}</flux:text>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 bg-zinc-50/50 dark:bg-zinc-900/30">
                            @foreach ($allRoles as $role)
                                <flux:checkbox
                                    wire:key="role-{{ $role->id }}"
                                    wire:model="selectedRoles"
                                    value="{{ $role->id }}"
                                    :label="$role->name"
                                />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center gap-3 p-6">
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">{{ __('Create User') }}</span>
                        <span wire:loading wire:target="save">{{ __('Creating…') }}</span>
                    </flux:button>
                    <flux:button
                        variant="ghost"
                        href="{{ route('admin.users.index') }}"
                        wire:navigate.hover
                    >
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
