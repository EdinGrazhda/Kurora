<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.roles.index') }}" wire:navigate.hover>{{ __('Roles') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Edit') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-2xl">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500/10 dark:bg-amber-500/20">
                <flux:icon name="pencil" class="size-5 text-amber-500" />
            </div>
            <div>
                <flux:heading size="lg">{{ __('Edit Role') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ __('Update the role name or its assigned permissions.') }}</flux:text>
            </div>
        </div>

        {{-- Form card --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50">
            <form wire:submit="update" class="divide-y divide-zinc-200 dark:divide-zinc-700">

                {{-- Basic info section --}}
                <div class="p-6 space-y-5">
                    <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400">{{ __('Basic Information') }}</flux:text>

                    <flux:input
                        wire:model="name"
                        :label="__('Role Name')"
                        required
                        autofocus
                    />

                    <flux:input
                        wire:model="guardName"
                        :label="__('Guard')"
                    />
                </div>

                {{-- Permissions section --}}
                @if ($allPermissions->isNotEmpty())
                    <div class="p-6">
                        <flux:text class="text-xs font-semibold uppercase tracking-wider text-zinc-400 mb-3">{{ __('Permissions') }}</flux:text>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-72 overflow-y-auto rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 bg-zinc-50/50 dark:bg-zinc-900/30">
                            @foreach ($allPermissions as $permission)
                                <flux:checkbox
                                    wire:key="perm-{{ $permission->id }}"
                                    wire:model="selectedPermissions"
                                    :value="(string) $permission->id"
                                    :label="$permission->name"
                                />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center gap-3 p-6">
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="update">
                        <span wire:loading.remove wire:target="update">{{ __('Save Changes') }}</span>
                        <span wire:loading wire:target="update">{{ __('Saving…') }}</span>
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('admin.roles.index') }}" wire:navigate.hover>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>

            </form>
        </div>
    </div>
</div>