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
        <flux:breadcrumbs.item>{{ __('Permissions') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500/10 dark:bg-teal-500/20">
                <flux:icon name="shield-check" class="size-5 text-teal-500" />
            </div>
            <div>
                <flux:heading size="xl">{{ __('Permissions') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ __('Manage system permissions and access controls') }}</flux:text>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Search permissions…') }}"
                clearable
                icon="magnifying-glass"
                class="w-60"
            />
            <flux:button
                variant="primary"
                href="{{ route('admin.permissions.create') }}"
                wire:navigate.hover
                icon="plus"
            >
                {{ __('New Permission') }}
            </flux:button>
        </div>
    </div>

    {{-- Table card --}}
    <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
        <flux:table :paginate="$this->permissions">
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Guard') }}</flux:table.column>
                <flux:table.column>{{ __('Roles') }}</flux:table.column>
                <flux:table.column>{{ __('Created') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->permissions as $permission)
                    <flux:table.row :key="$permission->id" class="transition-colors hover:bg-zinc-50 dark:hover:bg-zinc-700/30">
                        <flux:table.cell>
                            <div class="flex items-center gap-2.5">
                                <div class="flex h-7 w-7 items-center justify-center rounded-md bg-teal-500/10 dark:bg-teal-500/15">
                                    <flux:icon name="key" class="size-3.5 text-teal-500" />
                                </div>
                                <span class="font-semibold">{{ $permission->name }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" variant="outline" class="font-mono text-xs">{{ $permission->guard_name }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" color="teal">{{ $permission->roles_count }} {{ trans_choice('role|roles', $permission->roles_count) }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 text-sm">
                            {{ $permission->created_at?->diffForHumans() }}
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:dropdown position="bottom" align="end">
                                <flux:button size="sm" variant="ghost" icon="ellipsis-horizontal" />
                                <flux:menu>
                                    <flux:menu.item
                                        icon="eye"
                                        href="{{ route('admin.permissions.show', $permission) }}"
                                        wire:navigate.hover
                                    >
                                        {{ __('View Details') }}
                                    </flux:menu.item>
                                    <flux:menu.item
                                        icon="pencil"
                                        href="{{ route('admin.permissions.edit', $permission) }}"
                                        wire:navigate.hover
                                    >
                                        {{ __('Edit') }}
                                    </flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item
                                        icon="trash"
                                        variant="danger"
                                        wire:click="confirmDelete({{ $permission->id }})"
                                    >
                                        {{ __('Delete') }}
                                    </flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5">
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <div class="flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700/50 mb-4">
                                    <flux:icon name="shield-check" class="size-7 text-zinc-400" />
                                </div>
                                <flux:heading size="sm" class="text-zinc-500">
                                    {{ $search ? __('No permissions match your search') : __('No permissions yet') }}
                                </flux:heading>
                                <flux:text class="text-sm text-zinc-400 mt-1">
                                    {{ $search ? __('Try adjusting your search terms.') : __('Create your first permission to get started.') }}
                                </flux:text>
                                @unless ($search)
                                    <flux:button
                                        variant="primary"
                                        size="sm"
                                        href="{{ route('admin.permissions.create') }}"
                                        wire:navigate.hover
                                        icon="plus"
                                        class="mt-4"
                                    >
                                        {{ __('New Permission') }}
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
                <flux:heading size="lg">{{ __('Delete permission?') }}</flux:heading>
            </div>
            <flux:text class="text-zinc-500">{{ __('This will permanently delete the permission and remove it from all roles. This action cannot be undone.') }}</flux:text>

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