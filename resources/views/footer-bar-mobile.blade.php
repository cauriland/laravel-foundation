@props([
    'isCauriProduct'  => true,
    'class'         => '',
    'copyClass'     => '',
    'copyText'      => null,
    'socials'       => null,
    'copyrightSlot' => null,
])

<div class="flex flex-col {{ $class }}">
    <x-cauri-footer-copyright
        :is-cauri-product="$isCauriProduct"
        :copy-text="$copyText"
        :class="$copyClass"
        :copyright-slot="$copyrightSlot"
    />

    <x-cauri-footer-social :networks="$socials" />
</div>
