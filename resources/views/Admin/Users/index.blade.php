<div class="space-y-6">
    {{-- Flash message --}}
    @if (session('success'))
        <div class="relative overflow-hidden rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-4">
            <div class="flex items-center gap-3">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-500/10">
                    <flux:icon name="check-circle" class="size-5 text-emerald-500" />
                </div>
                <flux:text class="font-medium text-emerald-600 dark:text-emerald-400">{{ session('success') }}</flux:text>
            </div>
        </div>
    @endif

    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item>{{ __('Users') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500/10 dark:bg-emerald-500/20">
                <flux:icon name="users" class="size-5 text-emerald-500" />
            </div>
            <div>
                <flux:heading size="xl">{{ __('Users') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ __('Manage user accounts and role assignments') }}</flux:text>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Search users…') }}"
                clearable
                icon="magnifying-glass"
                class="w-60"
            />
            <flux:button
                variant="primary"
                href="{{ route('admin.users.create') }}"
                wire:navigate.hover
                icon="plus"
            >
                {{ __('New User') }}
            </flux:button>
        </div>
    </div>

    {{-- Table card --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column>{{ __('User') }}</flux:table.column>
                <flux:table.column>{{ __('Roles') }}</flux:table.column>
                <flux:table.column>{{ __('Created') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->users as $user)
                    <flux:table.row :key="$user->id" class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                <flux:avatar :name="$user->name" size="sm" class="shrink-0" />
                                <div class="min-w-0">
                                    <div class="font-semibold truncate">{{ $user->name }}</div>
                                    <div class="text-sm text-zinc-500 truncate">{{ $user->email }}</div>
                                </div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse ($user->roles as $role)
                                    <flux:badge wire:key="user-{{ $user->id }}-role-{{ $role->id }}" size="sm" variant="outline">{{ $role->name }}</flux:badge>
                                @empty
                                    <span class="text-zinc-400 text-sm italic">{{ __('No roles') }}</span>
                                @endforelse
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 text-sm">
                            {{ $user->created_at?->diffForHumans() }}
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:dropdown position="bottom" align="end">
                                <flux:button size="sm" variant="ghost" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item
                                        icon="eye"
                                        href="{{ route('admin.users.show', $user) }}"
                                        wire:navigate.hover
                                    >
                                        {{ __('View Profile') }}
                                    </flux:menu.item>
                                    <flux:menu.item
                                        icon="shield-check"
                                        href="{{ route('admin.users.roles', $user) }}"
                                        wire:navigate.hover
                                    >
                                        {{ __('Assign Roles') }}
                                    </flux:menu.item>
                                    <flux:menu.item
                                        icon="pencil"
                                        href="{{ route('admin.users.edit', $user) }}"
                                        wire:navigate.hover
                                    >
                                        {{ __('Edit') }}
                                    </flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        wire:click="confirmDelete({{ $user->id }})"
                                    >
                                        {{ __('Delete') }}
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4">
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700/50 mb-4">
                                    <flux:icon name="users" class="size-7 text-zinc-400" />
                                </div>
                                <flux:heading size="sm" class="text-zinc-500">
                                    {{ $search ? __('No users match your search') : __('No users yet') }}
                                </flux:heading>
                                <flux:text class="text-sm text-zinc-400 mt-1">
                                    {{ $search ? __('Try adjusting your search terms.') : __('Create your first user to get started.') }}
                                </flux:text>
                                @unless ($search)
                                    <flux:button
                                        variant="primary"
                                        size="sm"
                                        href="{{ route('admin.users.create') }}"
                                        wire:navigate.hover
                                        icon="plus"
                                        class="mt-4"
                                    >
                                        {{ __('New User') }}
                                    </flux:button>
                                @endunless
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </div>

    {{-- Delete confirmation modal --}}
    <flux:modal name="confirm-delete" class="max-w-sm">
        <div class="space-y-4">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500/10">
                    <flux:icon name="exclamation-triangle" class="size-5 text-red-500" />
                </div>
                <flux:heading size="lg">{{ __('Delete user?') }}</flux:heading>
            </div>
            <flux:text class="text-zinc-500">{{ __('This will permanently delete the user account. This action cannot be undone.') }}</flux:text>

            <div class="flex justify-end gap-3 pt-2">
                <flux:button
                    variant="ghost"
                    wire:click="cancelDelete"
                    x-on:click="$flux.modal('confirm-delete').close()"
                >
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button
                    variant="danger"
                    wire:click="delete"
                    wire:loading.attr="disabled"
                    wire:target="delete"
                >
                    <span wire:loading.remove wire:target="delete">{{ __('Delete') }}</span>
                    <span wire:loading wire:target="delete">{{ __('Deleting…') }}</span>
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
