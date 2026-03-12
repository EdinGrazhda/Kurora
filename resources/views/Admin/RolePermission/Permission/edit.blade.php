<div>
    <div class="max-w-xl space-y-6">

        <div>
            <flux:heading size="lg">{{ __('Edit Permission') }}</flux:heading>
            <flux:text class="text-zinc-500">{{ __('Update the permission name or guard.') }}</flux:text>
        </div>

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

            <div class="flex items-center gap-3 pt-2">
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Save Changes') }}</span>
                    <span wire:loading>{{ __('Saving…') }}</span>
                </flux:button>
                <flux:button variant="ghost" href="{{ route('admin.permissions.index') }}" wire:navigate.hover>
                    {{ __('Cancel') }}
                </flux:button>
            </div>

        </form>
    </div>
</div>