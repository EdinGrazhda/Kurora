<div>
    <div class="max-w-3xl mx-auto">
        <flux:heading size="xl" class="mb-1">{{ __('Assign Roles') }}</flux:heading>
        <flux:text class="mb-6 text-zinc-500">{{ $userName }} ({{ $userEmail }})</flux:text>

        <form wire:submit="save" class="space-y-6">
            {{-- Search + bulk actions --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search roles…') }}"
                    clearable
                    icon="magnifying-glass"
                    class="w-56"
                />

                <div class="flex items-center gap-2">
                    <flux:button size="sm" variant="ghost" wire:click="selectAll" type="button">
                        {{ __('Select All') }}
                    </flux:button>
                    <flux:button size="sm" variant="ghost" wire:click="deselectAll" type="button">
                        {{ __('Deselect All') }}
                    </flux:button>
                </div>
            </div>

            {{-- Role checkboxes --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @forelse ($allRoles as $role)
                    <flux:checkbox
                        wire:model="selectedRoles"
                        value="{{ $role->id }}"
                        :label="$role->name"
                    />
                @empty
                    <flux:text class="col-span-full text-zinc-400 italic">
                        {{ $search ? __('No roles match your search.') : __('No roles available.') }}
                    </flux:text>
                @endforelse
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2">
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ __('Save Roles') }}</span>
                    <span wire:loading wire:target="save">{{ __('Saving…') }}</span>
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
