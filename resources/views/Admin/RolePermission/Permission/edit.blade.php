<div class="space-y-6">
    {{-- Breadcrumb --}}
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate.hover icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.permissions.index') }}" wire:navigate.hover>{{ __('Permissions') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ __('Edit') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="max-w-xl">
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500/10 dark:bg-amber-500/20">
                <flux:icon name="pencil" class="size-5 text-amber-500" />
            </div>
            <div>
                <flux:heading size="lg">{{ __('Edit Permission') }}</flux:heading>
                <flux:text class="text-sm text-zinc-500">{{ __('Update the permission name or guard.') }}</flux:text>
            </div>
        </div>

        {{-- Form card --}}
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800/50 p-6">
            <form wire:submit="update" class="space-y-5">

                <flux:input
                    wire:model="name"
                    :label="__('Permission Name')"
                    required
                    autofocus
                />

                <flux:input
                    wire:model="guardName"
                    :label="__('Guard')"
                />

                <div class="flex items-center gap-3 border-t border-zinc-200 dark:border-zinc-700 pt-5">
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="update">
                        <span wire:loading.remove wire:target="update">{{ __('Save Changes') }}</span>
                        <span wire:loading wire:target="update">{{ __('Saving…') }}</span>
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('admin.permissions.index') }}" wire:navigate.hover>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>

            </form>
        </div>
    </div>
</div>