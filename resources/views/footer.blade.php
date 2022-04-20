@props([
    'desktopClass'  => 'px-8 max-w-7xl hidden lg:flex',
    'mobileClass'   => 'px-8 pb-8 lg:hidden',
    'copyClass'     => '',
    'copyText'      => null,
    'isCauriProduct'  => true,
    'socials'       => null,
    'copyrightSlot' => null,
])

<div {{ $attributes->merge(['class' => 'border-t bg-theme-secondary-900 border-theme-secondary-800']) }}>
    <div class="{{ $desktopClass }} flex-col mx-auto">
        <x-cauri-footer-bar-desktop
            :is-cauri-product="$isCauriProduct"
            :copy-class="$copyClass"
            :copy-text="$copyText"
            :socials="$socials"
            :copyright-slot="$copyrightSlot"
            no-border
        />
    </div>

    <x-cauri-footer-bar-mobile
        :class="$mobileClass"
        :is-cauri-product="$isCauriProduct"
        :copy-class="$copyClass"
        :copy-text="$copyText"
        :socials="$socials"
        :copyright-slot="$copyrightSlot"
    />
</div>
