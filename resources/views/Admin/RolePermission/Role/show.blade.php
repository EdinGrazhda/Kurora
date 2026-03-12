<div class="max-w-xl space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="lg">{{ $role->name }}</flux:heading>
                <flux:text class="text-zinc-500">{{ __('Guard: :guard', ['guard' => $role->guard_name]) }}</flux:text>
            </div>
            <div class="flex items-center gap-2">
                <flux:button
                    variant="ghost"
                    icon="pencil"
                    href="{{ route('admin.roles.edit', $role) }}"
                    wire:navigate.hover
                >
                    {{ __('Edit') }}
                </flux:button>
                <flux:button variant="ghost" href="{{ route('admin.roles.index') }}" wire:navigate.hover>
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>

        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 space-y-4">

            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-500">{{ __('Created') }}</span>
                <span class="font-medium">{{ $role->created_at?->toDateTimeString() }}</span>
            </div>

            <div class="flex items-start justify-between text-sm">
                <span class="text-zinc-500">{{ __('Permissions') }}</span>
                <flux:badge>{{ $role->permissions->count() }}</flux:badge>
            </div>

            @if ($role->permissions->isNotEmpty())
                <div class="flex flex-wrap gap-2 pt-1">
                    @foreach ($role->permissions as $permission)
                        <flux:badge size="sm" variant="outline">{{ $permission->name }}</flux:badge>
                    @endforeach
                </div>
            @else
                <flux:text class="text-zinc-400 text-sm italic">{{ __('No permissions assigned.') }}</flux:text>
            @endif

        </div>

</div>