<x-cauri-js-modal
    init
    name="alertModal"
    :title="trans('ui::markdown.modals.alert.title')"
    width-class="max-w-lg"
>
    @slot('description')
        <form id="alertModalForm" @submit.prevent="Livewire.emit('alertModal', $event)" class="space-y-4">
            <x-cauri-select
                name="type"
                :label="trans('ui::markdown.modals.alert.form.type')"
            >
                @foreach(trans('ui::markdown.modals.alert.form.types') as $type => $label)
                    <option value="{{ $type }}">
                        {{ $label }}
                    </option>
                @endforeach
            </x-cauri-select>

            <x-cauri-input
                type="text"
                name="text"
                :label="trans('ui::markdown.modals.alert.form.text')"
                class="w-full"
            />
        </form>
    @endslot

    @slot('buttons')
        <button @click="hide" type="button" class="button-secondary">
            @lang('ui::actions.cancel')
        </a>

        <button type="submit" class="button-primary" form="alertModalForm">
            @lang('ui::actions.ok')
        </button>
    @endslot
</x-cauri-js-modal>

