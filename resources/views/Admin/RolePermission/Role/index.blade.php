<div>
        {{-- Flash message --}}
        @if (session('success'))
            <flux:callout variant="success" class="mb-4">
                <flux:callout.heading>{{ session('success') }}</flux:callout.heading>
            </flux:callout>
        @endif

        {{-- Header row --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <flux:heading size="xl">{{ __('Roles') }}</flux:heading>

            <div class="flex items-center gap-3">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search roles…') }}"
                    clearable
                    icon="magnifying-glass"
                    class="w-56"
                />
                <flux:button
                    variant="primary"
                    href="{{ route('admin.roles.create') }}"
                    wire:navigate.hover
                    icon="plus"
                >
                    {{ __('New Role') }}
                </flux:button>
            </div>
        </div>

        {{-- Table --}}
        <flux:table :paginate="$this->roles">
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Guard') }}</flux:table.column>
                <flux:table.column>{{ __('Permissions') }}</flux:table.column>
                <flux:table.column>{{ __('Created') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->roles as $role)
                    <flux:table.row :key="$role->id">
                        <flux:table.cell class="font-medium">{{ $role->name }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" variant="outline">{{ $role->guard_name }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm">{{ $role->permissions_count }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 text-sm">
                            {{ $role->created_at?->toDateString() }}
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button
                                    size="sm"
                                    variant="ghost"
                                    icon="eye"
                                    href="{{ route('admin.roles.show', $role) }}"
                                    wire:navigate.hover
                                    :aria-label="__('View') . ' ' . $role->name"
                                />
                                <flux:button
                                    size="sm"
                                    variant="ghost"
                                    icon="shield-check"
                                    href="{{ route('admin.roles.permissions', $role) }}"
                                    wire:navigate.hover
                                    :aria-label="__('Assign Permissions') . ' ' . $role->name"
                                />
                                <flux:button
                                    size="sm"
                                    variant="ghost"
                                    icon="pencil"
                                    href="{{ route('admin.roles.edit', $role) }}"
                                    wire:navigate.hover
                                    :aria-label="__('Edit') . ' ' . $role->name"
                                />
                                <flux:button
                                    size="sm"
                                    variant="ghost"
                                    icon="trash"
                                    wire:click="confirmDelete({{ $role->id }})"
                                    :aria-label="__('Delete') . ' ' . $role->name"
                                />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center text-zinc-400 py-10">
                            {{ $search ? __('No roles match your search.') : __('No roles found.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        {{-- Delete confirmation modal --}}
        <flux:modal name="confirm-delete" class="max-w-sm">
            <div class="space-y-4">
                <flux:heading size="lg">{{ __('Delete role?') }}</flux:heading>
                <flux:text>{{ __('This will permanently delete the role and revoke it from all users. This action cannot be undone.') }}</flux:text>

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