<div>
    <div class="max-w-2xl mx-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <flux:heading size="xl">{{ $user->name }}</flux:heading>

            <div class="flex items-center gap-2">
                <flux:button
                    size="sm"
                    variant="ghost"
                    icon="pencil"
                    href="{{ route('admin.users.edit', $user) }}"
                    wire:navigate.hover
                >
                    {{ __('Edit') }}
                </flux:button>
                <flux:button
                    size="sm"
                    variant="ghost"
                    href="{{ route('admin.users.index') }}"
                    wire:navigate.hover
                >
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>

        {{-- Details card --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 divide-y divide-zinc-200 dark:divide-zinc-700">
            <div class="px-5 py-4 flex items-center justify-between">
                <flux:text class="font-medium text-zinc-500">{{ __('Email') }}</flux:text>
                <flux:text>{{ $user->email }}</flux:text>
            </div>

            <div class="px-5 py-4 flex items-start justify-between">
                <flux:text class="font-medium text-zinc-500">{{ __('Roles') }}</flux:text>
                <div class="flex flex-wrap gap-1 justify-end">
                    @forelse ($user->roles as $role)
                        <flux:badge size="sm" variant="outline">{{ $role->name }}</flux:badge>
                    @empty
                        <span class="text-zinc-400 text-sm italic">{{ __('None') }}</span>
                    @endforelse
                </div>
            </div>

            <div class="px-5 py-4 flex items-start justify-between">
                <flux:text class="font-medium text-zinc-500">{{ __('Permissions via Roles') }}</flux:text>
                <div class="flex flex-wrap gap-1 justify-end">
                    @forelse ($user->getAllPermissions() as $permission)
                        <flux:badge size="sm" color="lime">{{ $permission->name }}</flux:badge>
                    @empty
                        <span class="text-zinc-400 text-sm italic">{{ __('None') }}</span>
                    @endforelse
                </div>
            </div>

            <div class="px-5 py-4 flex items-center justify-between">
                <flux:text class="font-medium text-zinc-500">{{ __('Created') }}</flux:text>
                <flux:text>{{ $user->created_at?->toDayDateTimeString() }}</flux:text>
            </div>

            <div class="px-5 py-4 flex items-center justify-between">
                <flux:text class="font-medium text-zinc-500">{{ __('Updated') }}</flux:text>
                <flux:text>{{ $user->updated_at?->toDayDateTimeString() }}</flux:text>
            </div>
        </div>
    </div>
</div>
