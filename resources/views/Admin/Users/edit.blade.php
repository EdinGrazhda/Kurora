<div>
    <div class="max-w-2xl mx-auto">
        <flux:heading size="xl" class="mb-6">{{ __('Edit User') }}</flux:heading>

        <form wire:submit="update" class="space-y-6">
            <flux:input
                wire:model="name"
                :label="__('Name')"
                placeholder="{{ __('Full name') }}"
                required
            />

            <flux:input
                wire:model="email"
                type="email"
                :label="__('Email')"
                placeholder="{{ __('user@example.com') }}"
                required
            />

            <flux:input
                wire:model="password"
                type="password"
                :label="__('New Password')"
                placeholder="{{ __('Leave blank to keep current') }}"
            />

            <flux:input
                wire:model="password_confirmation"
                type="password"
                :label="__('Confirm New Password')"
                placeholder="{{ __('Repeat new password') }}"
            />

            {{-- Role selection --}}
            @if ($allRoles->isNotEmpty())
                <div>
                    <flux:label>{{ __('Roles') }}</flux:label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                        @foreach ($allRoles as $role)
                            <flux:checkbox
                                wire:model="selectedRoles"
                                value="{{ $role->id }}"
                                :label="$role->name"
                            />
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex items-center gap-3 pt-2">
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="update">
                    <span wire:loading.remove wire:target="update">{{ __('Save Changes') }}</span>
                    <span wire:loading wire:target="update">{{ __('Saving…') }}</span>
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
