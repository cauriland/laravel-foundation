<div class="flex fixed right-0 bottom-0 z-50 flex-col items-end p-5 space-y-3">
    @foreach ($toasts as $key => $toast)
        <div
            class="z-20 cursor-pointer"
            x-data="{ dismiss() { livewire.emit('dismissToast', '{{ $key }}' ) } }"
            x-init="$nextTick(() => setTimeout(() => dismiss(), 5000))"
            @click="dismiss()"
            wire:key="{{ $key }}"
        >
            <x-cauri-toast :type="$toast['type']" wire-close="dismissToast('{{ $key }}')">
                <x-slot name='message'>
                    {!! $toast['message'] !!}
                </x-slot>
            </x-cauri-toast>
        </div>
    @endforeach
</div>
