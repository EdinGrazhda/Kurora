<div>
    <div class="max-w-xl space-y-6">

            <div>
                <flux:heading size="lg">{{ __('Edit Role') }}</flux:heading>
                <flux:text class="text-zinc-500">{{ __('Update the role name or its assigned permissions.') }}</flux:text>
            </div>

            <form wire:submit="update" class="space-y-5">

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

                {{-- Permissions checkboxes --}}
                @if ($allPermissions->isNotEmpty())
                    <div>
                        <flux:label>{{ __('Permissions') }}</flux:label>
                        <div class="mt-2 grid sm:grid-cols-2 gap-2 max-h-72 overflow-y-auto rounded-lg border border-zinc-200 dark:border-zinc-700 p-4">
                            @foreach ($allPermissions as $permission)
                                <flux:checkbox
                                    wire:model="selectedPermissions"
                                    :value="(string) $permission->id"
                                    :label="$permission->name"
                                />
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ __('Save Changes') }}</span>
                        <span wire:loading>{{ __('Saving…') }}</span>
                    </flux:button>
                    <flux:button variant="ghost" href="{{ route('admin.roles.index') }}" wire:navigate.hover>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>

            </form>
    </div>
</div>