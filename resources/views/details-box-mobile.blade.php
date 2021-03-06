@props([
    'title',
    'icon'         => null,
    'iconRaw'      => null,
    'iconClass'    => null,
    'slotClass'    => null,
    'titleClass'   => 'w-32',
    'wrapperClass' => null,
])

<div class="flex justify-between">
    <div class="{{ $titleClass }}">{{ $title }}</div>

    <div class="flex items-center space-x-3 {{ $wrapperClass }}">
        <div class="{{ $slotClass }}">{{ $slot }}</div>

        @if ($icon)
            <x-cauri-icon :name="$icon" class="{{ $iconClass }}" />
        @elseif ($iconRaw)
            {{ $iconRaw }}
        @endif
    </div>
</div>
