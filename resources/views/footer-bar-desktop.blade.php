@props([
    'isCauriProduct'  => true,
    'noBorder'      => '',
    'copyClass'     => '',
    'copyText'      => null,
    'socials'       => null,
    'copyrightSlot' => null,
])

<div class="flex items-center justify-between @unless ($noBorder) border-t border-theme-secondary-800 @endunless">
    <x-cauri-footer-copyright
        :is-cauri-product="$isCauriProduct"
        :copy-text="$copyText"
        :class="$copyClass"
        :copyright-slot="$copyrightSlot"
    />

    <x-cauri-footer-social :networks="$socials" />
</div>
