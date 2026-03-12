<div class="max-w-xl space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">{{ $permission->name }}</flux:heading>
            <flux:text class="text-zinc-500">{{ __('Guard: :guard', ['guard' => $permission->guard_name]) }}</flux:text>
        </div>
        <div class="flex items-center gap-2">
            <flux:button
                variant="ghost"
                icon="pencil"
                href="{{ route('admin.permissions.edit', $permission) }}"
                wire:navigate.hover
            >
                {{ __('Edit') }}
            </flux:button>
            <flux:button variant="ghost" href="{{ route('admin.permissions.index') }}" wire:navigate.hover>
                {{ __('Back') }}
            </flux:button>
        </div>
    </div>

    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 space-y-4">

        <div class="flex items-center justify-between text-sm">
            <span class="text-zinc-500">{{ __('Created') }}</span>
            <span class="font-medium">{{ $permission->created_at?->toDateTimeString() }}</span>
        </div>

        <div class="flex items-start justify-between text-sm">
            <span class="text-zinc-500">{{ __('Used by Roles') }}</span>
            <flux:badge>{{ $permission->roles->count() }}</flux:badge>
        </div>

        @if ($permission->roles->isNotEmpty())
            <div class="flex flex-wrap gap-2 pt-1">
                @foreach ($permission->roles as $role)
                    <flux:badge size="sm" variant="outline">{{ $role->name }}</flux:badge>
                @endforeach
            </div>
        @else
            <flux:text class="text-zinc-400 text-sm italic">{{ __('Not assigned to any role.') }}</flux:text>
        @endif

    </div>

</div>