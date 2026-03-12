<div>
    <div class="max-w-xl space-y-6">

        <div>
            <flux:heading size="lg">{{ __('Create Permission') }}</flux:heading>
            <flux:text class="text-zinc-500">{{ __('Define a new permission that can be assigned to roles.') }}</flux:text>
        </div>

        <form wire:submit="save" class="space-y-5">

            <flux:input
                wire:model="name"
                :label="__('Permission Name')"
                placeholder="e.g. edit-posts"
                required
                autofocus
            />

            <flux:input
                wire:model="guardName"
                :label="__('Guard')"
                placeholder="web"
            />

            <div class="flex items-center gap-3 pt-2">
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Create Permission') }}</span>
                    <span wire:loading>{{ __('Creating…') }}</span>
                </flux:button>
                <flux:button variant="ghost" href="{{ route('admin.permissions.index') }}" wire:navigate.hover>
                    {{ __('Cancel') }}
                </flux:button>
            </div>

        </form>
    </div>
</div>