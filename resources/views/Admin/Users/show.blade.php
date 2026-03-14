<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.users.index') }}" wire:navigate.hover>{{ __('Users') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $user->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-2xl">
        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
            <div class="flex items-center gap-3">
                <flux:avatar :name="$user->name" size="lg" />
                <div>
                    <flux:heading size="lg">{{ $user->name }}</flux:heading>
                    <flux:text class="text-sm text-zinc-500">{{ $user->email }}</flux:text>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <flux:button
                    variant="primary"
                    size="sm"
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
                    icon="arrow-left"
                >
                    {{ __('Back') }}
                </flux:button>
            </div>
        </div>

        {{-- Details card --}}
        <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
            <div class="divide-y divide-zinc-200 dark:divide-zinc-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="envelope" class="size-4" />
                        {{ __('Email') }}
                    </div>
                    <flux:text class="font-medium">{{ $user->email }}</flux:text>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="calendar" class="size-4" />
                        {{ __('Created') }}
                    </div>
                    <flux:text class="font-medium">{{ $user->created_at?->toDayDateTimeString() }}</flux:text>
                </div>

                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-2 text-sm text-zinc-500">
                        <flux:icon name="clock" class="size-4" />
                        {{ __('Updated') }}
                    </div>
                    <flux:text class="font-medium">{{ $user->updated_at?->toDayDateTimeString() }}</flux:text>
                </div>
            </div>

            {{-- Roles section --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-5">
                <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">{{ __('Assigned Roles') }}</flux:text>
                <div class="flex flex-wrap gap-2">
                    @forelse ($user->roles as $role)
                        <flux:badge wire:key="role-{{ $role->id }}" size="sm" variant="outline" class="px-3 py-1">{{ $role->name }}</flux:badge>
                    @empty
                        <span class="text-zinc-400 text-sm italic">{{ __('No roles assigned') }}</span>
                    @endforelse
                </div>
            </div>

            {{-- Permissions section --}}
            <div class="border-t border-zinc-200 dark:border-zinc-700 px-6 py-5">
                <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">{{ __('Permissions via Roles') }}</flux:text>
                <div class="flex flex-wrap gap-2">
                    @forelse ($user->getAllPermissions() as $permission)
                        <flux:badge wire:key="perm-{{ $permission->id }}" size="sm" color="lime" class="px-3 py-1">{{ $permission->name }}</flux:badge>
                    @empty
                        <span class="text-zinc-400 text-sm italic">{{ __('No permissions') }}</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
