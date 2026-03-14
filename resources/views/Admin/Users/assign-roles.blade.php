<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.users.index') }}" wire:navigate.hover>{{ __('Users') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Assign Roles') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-3xl">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-500/10 dark:bg-teal-500/20">
                <flux:icon name="shield-check" class="size-5 text-teal-500" />
            </div>
            <div>
                <flux:heading size="lg">{{ __('Assign Roles') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ $userName }} &middot; {{ $userEmail }}</flux:text>
            </div>
        </div>

        {{-- Card --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
            <form wire:submit="save" class="divide-y divide-zinc-200 dark:divide-zinc-700">

                {{-- Toolbar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-5">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search roles…') }}"
                        clearable
                        icon="magnifying-glass"
                        class="w-60"
                    />

                    <div class="flex items-center gap-2">
                        <flux:button size="sm" variant="ghost" wire:click="selectAll" type="button" icon="check-circle">
                            {{ __('Select All') }}
                        </flux:button>
                        <flux:button size="sm" variant="ghost" wire:click="deselectAll" type="button" icon="x-circle">
                            {{ __('Deselect All') }}
                        </flux:button>
                    </div>
                </div>

                {{-- Role checkboxes --}}
                <div class="p-5">
                    @forelse ($allRoles as $role)
                        @if ($loop->first)
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 bg-zinc-50/50 dark:bg-zinc-900/30">
                        @endif
                                <flux:checkbox
                                    wire:key="role-{{ $role->id }}"
                                    wire:model="selectedRoles"
                                    value="{{ $role->id }}"
                                    :label="$role->name"
                                />
                        @if ($loop->last)
                            </div>
                        @endif
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700/50 mb-3">
                                <flux:icon name="user-group" class="size-6 text-zinc-400" />
                            </div>
                            <flux:text class="text-zinc-400 italic">
                                {{ $search ? __('No roles match your search.') : __('No roles available.') }}
                            </flux:text>
                        </div>
                    @endforelse
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 p-5">
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
</div>
