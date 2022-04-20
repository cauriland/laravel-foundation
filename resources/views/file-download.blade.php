<div
    x-data="fileDownload()"
    class="{{ $wrapperClass ?? '' }}"
>
    <button
        type="button"
        class="button-secondary flex items-center {{ $class ?? '' }}"
        @click="save('{{ $filename }}', '{{ $content }}', '{{ $type ?? 'text/plain' }}', '{{ $extension ?? 'txt'}}')"
    >
        <x-cauri-icon name="arrows.arrow-down-bracket" size="sm" />

        <span class="ml-2">{{ ($title ?? '') ? $title : trans('ui::actions.save') }}</span>
    </button>
</div>
