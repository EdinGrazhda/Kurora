<div>
    <div class="max-w-2xl space-y-6">

        <div>
            <flux:heading size="lg">{{ __('Assign Permissions') }}</flux:heading>
            <flux:text class="text-zinc-500">
                {{ __('Manage permissions for role ":role".', ['role' => $roleName]) }}
            </flux:text>
        </div>

        {{-- Search + bulk actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Search permissions…') }}"
                clearable
                icon="magnifying-glass"
                class="w-56"
            />
            <div class="flex items-center gap-2">
                <flux:button size="sm" variant="ghost" wire:click="selectAll">
                    {{ __('Select All') }}
                </flux:button>
                <flux:button size="sm" variant="ghost" wire:click="deselectAll">
                    {{ __('Deselect All') }}
                </flux:button>
            </div>
        </div>

        {{-- Permissions grid --}}
        <form wire:submit="save" class="space-y-5">
            @if ($allPermissions->isNotEmpty())
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-96 overflow-y-auto rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                    @foreach ($allPermissions as $permission)
                        <flux:checkbox
                            wire:model="selectedPermissions"
                            :value="(string) $permission->id"
                            :label="$permission->name"
                        />
                    @endforeach
                </div>
            @else
                <flux:text class="text-zinc-400 italic py-6 text-center">
                    {{ $search ? __('No permissions match your search.') : __('No permissions exist yet.') }}
                </flux:text>
            @endif

            <div class="flex items-center gap-3 pt-2">
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Save Permissions') }}</span>
                    <span wire:loading>{{ __('Saving…') }}</span>
                </flux:button>
                <flux:button variant="ghost" href="{{ route('admin.roles.index') }}" wire:navigate.hover>
                    {{ __('Cancel') }}
                </flux:button>
            </div>
        </form>

    </div>
</div>
