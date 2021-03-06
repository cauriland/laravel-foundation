@props([
    'xData' => '{}',
    'class' => '',
    'style' => null,
    'widthClass' => 'max-w-2xl',
    'name' => null,
    'title' => null,
    'titleClass' => 'inline-block pb-2 font-bold dark:text-theme-secondary-200',
    'buttons' => null,
    'buttonsStyle' => 'modal-buttons',
    'closeButtonOnly' => false,
    'wireClose' => false,
    'escToClose' => true,
    'fixedPosition' => false,
    'paddingClass' => 'p-8 sm:p-10'
])

<div class="fixed inset-0 z-50 opacity-75 dark:opacity-50 bg-theme-secondary-900 dark:bg-theme-secondary-800"></div>

<div
    wire:ignore.self
    x-ref="modal"
    @if($name)
        data-modal="{{ $name }}"
    @else
        data-modal
    @endif
    x-data="Modal.livewire({{ $xData }})"
    @if(!$closeButtonOnly && $wireClose)
        @mousedown.self="$wire.{{ $wireClose }}()"
    @endif
    class="flex overflow-y-auto fixed inset-0 z-50 md:py-10 md:px-8"
    @if(!$closeButtonOnly && $escToClose)
        wire:keydown.escape="{{ $wireClose }}"
        tabindex="0"
    @endif
>
    <div
        class="modal-content-wrapper @if($fixedPosition) md:mx-auto @else md:m-auto @endif w-full {{ $class }} {{ $widthClass }}"
        @if($style) style="{{ $style }}" @endif
    >
        <div class="modal-content custom-scroll {{ $widthClass }}">
            <div class="{{ $paddingClass }}">
                @if($wireClose)
                    <button
                        type="button"
                        class="modal-close"
                        @if($wireClose ?? false) wire:click="{{ $wireClose }}" @endif
                    >
                        <x-cauri-icon name="cross" size="sm" class="m-auto" />
                    </button>
                @endif

                @if ($title)
                    <h1 class="{{ $titleClass }}">
                        {{ $title }}
                    </h1>
                @endif

                {{ $description }}

                @if($buttons ?? false)
                    <div class="mt-8 text-right {{ $buttonsStyle }}">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
