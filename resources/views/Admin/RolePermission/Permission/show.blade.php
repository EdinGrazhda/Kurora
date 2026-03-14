<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.permissions.index') }}" wire:navigate.hover>{{ __('Permissions') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $permission->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-2xl">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500/10 dark:bg-teal-500/20">
                    <flux:icon name="key" class="size-5 text-teal-500" />
                </div>
                <div>
                    <flux:heading size="lg">{{ $permission->name }}</flux:heading>
                    <flux:text class="text-sm text-zinc-500">{{ __('Guard: :guard', ['guard' => $permission->guard_name]) }}</flux:text>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <flux:button
                    variant="primary"
                    size="sm"
                    icon="pencil"
                    href="{{ route('admin.permissions.edit', $permission) }}"
                    wire:navigate.hover
                >
                    {{ __('Edit') }}
                </flux:button>
                <flux:button variant="ghost" size="sm" href="{{ route('admin.permissions.index') }}" wire:navigate.hover icon="arrow-left">
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>

        {{-- Details card --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="calendar" class="size-4" />
                        {{ __('Created') }}
                    </div>
                    <span class="text-sm font-medium">{{ $permission->created_at?->toDayDateTimeString() }}</span>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="shield-check" class="size-4" />
                        {{ __('Guard') }}
                    </div>
                    <flux:badge size="sm" variant="outline" class="font-mono">{{ $permission->guard_name }}</flux:badge>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="user-group" class="size-4" />
                        {{ __('Used by Roles') }}
                    </div>
                    <flux:badge size="sm" color="teal">{{ $permission->roles->count() }}</flux:badge>
                </div>
            </div>

            {{-- Roles section --}}
            @if ($permission->roles->isNotEmpty())
                <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-5">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">{{ __('Assigned Roles') }}</flux:text>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($permission->roles as $role)
                            <flux:badge wire:key="role-{{ $role->id }}" size="sm" variant="outline" class="px-3 py-1">{{ $role->name }}</flux:badge>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-8 text-center">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700/50 mx-auto mb-2">
                        <flux:icon name="shield-exclamation" class="size-5 text-zinc-400" />
                    </div>
                    <flux:text class="text-sm text-zinc-400 italic">{{ __('Not assigned to any role.') }}</flux:text>
                </div>
            @endif
        </div>
    </div>
</div>