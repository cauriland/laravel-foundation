@props([
    'isCauriProduct'  => true,
    'copyText'      => 'cauri.cm | ' . trans('ui::general.all_rights_reserved'),
    'copyrightSlot' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col py-6 space-y-2 font-semibold text-sm text-theme-secondary-700 sm:flex-row sm:space-y-0 sm:space-x-1'])}}>
    <span class="whitespace-nowrap">
        {{ date('Y') }} &copy; {{ $copyText }}
    </span>

    @if($isCauriProduct || $copyrightSlot !== null)
        <div class="flex">
            @if($isCauriProduct)
                <div>
                    <span class="hidden mr-1 sm:inline"> | </span>
                    <span class="whitespace-nowrap">
                        <x-cauri-icon
                            name="networks.cauri-square"
                            class="inline-block mr-1 -mt-1 cauri-logo-red"
                        />

                        An <a href="https://cauri.cm/" class="underline hover:no-underline focus-visible:rounded">cauri.cm</a> @lang('ui::generic.product')
                    </span>
                </div>
            @endif

            {{ $copyrightSlot }}
        </div>
    @endif
</div>
