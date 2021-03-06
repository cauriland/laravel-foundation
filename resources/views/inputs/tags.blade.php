@props([
    'xData' => '{}',
    'name',
    'errors',
    'tags' => [],
    'maxTags' => null,
    'allowedTags' => [],
    'id' => null,
    'label' => null,
    'tooltip' => null,
    'required' => false,
    'placeholder' => 'Enter tags',
    'isDisabled' => false,
    'addDisabled' => false,
    'removeDisabled' => false,
    'disabledInputTooltip' => '',
])

<div
    x-data="Tags({{ $xData }}, '{{ $id ?? $name }}', {{ json_encode($tags) }}, {{ json_encode($allowedTags) }}, '{{ $placeholder }}', {{ $isDisabled ? 'true' : 'false' }}, {{ $addDisabled ? 'true' : 'false' }}, {{ $removeDisabled ? 'true' : 'false' }}, '{{ $disabledInputTooltip }}', {{ $maxTags === null ? 'null' : $maxTags }})"
    {{ $attributes->merge(['class' => 'relative']) }}
>
    <div class="input-group">
        @unless ($hideLabel ?? false)
            @include('cauri::inputs.includes.input-label', [
                'name'     => $name,
                'errors'   => $errors,
                'id'       => $id !== null ? $id : $name,
                'label'    => $label ?? null,
                'tooltip'  => $tooltip ?? null,
                'required' => $required ?? false,
            ])
        @endunless

        <div @class([
            'input-wrapper',
            'disabled-tags-input'     => $isDisabled || $addDisabled,
            'disabled-tags-input-add' => $addDisabled,
        ])>
            <div
                wire:ignore
                x-ref="input"
                class="relative py-2 px-3 bg-white rounded border border-theme-secondary-400 dark:bg-theme-secondary-900 dark:border-theme-secondary-700"
            >
            </div>

            @error($name)
                @include('cauri::inputs.includes.input-error-tooltip', [
                    'error' => $message,
                    'id'    => $id ?? $name,
                ])
            @enderror
        </div>
    </div>
</div>
