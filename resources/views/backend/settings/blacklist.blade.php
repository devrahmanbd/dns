<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Blacklist') }}
    </x-slot>

    <x-slot name="description">
        {{ __('You can add/update/remove blacklist servers that are used to check whether a specific hostname is blacklist or not.') }}
    </x-slot>
    
    <x-slot name="form">
        <div class="col-span-6">
            <x-jet-label value="{{ __('Servers') }}" />
            <div class="grid grid-cols-2 gap-4 mt-4">
                @foreach($state['blacklist']['servers'] as $key => $server)
                <div>
                    <div class="flex">
                        <x-jet-input type="text" class="block w-full" wire:model.defer="state.blacklist.servers.{{ $key }}"/> 
                        <button type="button" wire:click="remove({{ $key }})" class="px-2 rounded-md ml-2 bg-red-700 text-white border-0"><i class="fas fa-trash"></i></button>  
                    </div> 
                    <x-jet-input-error for="state.blacklist.servers.{{ $key }}" class="mt-1 mb-2" />
                </div>
                @endforeach
            </div>
            <button type="button" wire:click="add" class="mt-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">{{ __('Add') }}</button>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button>
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>