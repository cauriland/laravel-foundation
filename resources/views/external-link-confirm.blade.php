{{-- External icon classes, dont remove are here for purgecss --}}
{{-- inline ml-1 -mt-1.5 --}}
<x-cauri-js-modal
    name="external-link-confirm"
    class="w-full max-w-2xl text-left rounded-xl"
    buttons-style="flex justify-end space-x-3"
    x-data="{
        url: null,
        hasConfirmedLinkWarning: false,
        toggle () {
            this.hasConfirmedLinkWarning = ! this.hasConfirmedLinkWarning;
        },
        onBeforeShow ([ url ]) {
            this.url = url;
        },
        onHidden () {
            this.hasConfirmedLinkWarning = false;
            document.querySelector('input[name=confirmation]').checked = false;
        },
        followLink() {
            if (this.hasConfirmedLinkWarning) {
                localStorage.setItem('has_disabled_link_warning', true)
            }

            this.hide();
        },
    }"
    init
>
    @slot('title')
        @lang('generic.external_link')
    @endslot

    @slot('description')
        <div class="flex flex-col mt-4 space-y-6 whitespace-normal">
            <div class="font-semibold text-theme-secondary-900">
                <x-cauri-alert type="warning">
                    <span class="block leading-6 break-words" x-text="url"></span>
                </x-cauri-alert>
            </div>

            <p>@lang('generic.external_link_disclaimer')</p>

            <x-cauri-checkbox
                name="confirmation"
                alpine="toggle"
                label-classes="text-theme-secondary-700 select-none"
            >
                @slot('label')
                    @lang('ui::forms.do_not_show_message_again')
                @endslot
            </x-cauri-checkbox>
        </div>
    @endslot

    @slot('buttons')
        <button
            class="button-secondary"
            @click="hide"
        >
            @lang('actions.back')
        </button>

        <a
            target="_blank"
            rel="noopener nofollow"
            class="cursor-pointer button-primary"
            :href="url"
            @click="followLink()"
            data-safe-external="true"
        >
            @lang('actions.follow_link')
        </a>
    @endslot
</x-cauri-js-modal>


<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function (event) {
    function initExternalLinkConfirm() {
        const selectors = [
            '[href*="://"]',
            ':not([href^="{{ config("app.url") }}"])',
            ':not([data-safe-external])',
            ':not([data-external-link-confirm])',
        ];

        const links = document.querySelectorAll(`a${selectors.join('')}`);

        const hasDisabledLinkWarning = () => localStorage.getItem('has_disabled_link_warning') === 'true';

        links.forEach(function (link) {
            link.setAttribute('data-external-link-confirm', 'true');

            const clickHandler = (e) => {
                if (hasDisabledLinkWarning()) {
                    return;
                }

                e.preventDefault();

                e.stopPropagation();

                Livewire.emit('openModal', 'external-link-confirm', link.getAttribute('href'));
            };

            link.addEventListener("auxclick", (event) => {
                if (event.button === 1) {
                    clickHandler(event);
                }
            });

            link.addEventListener('click', clickHandler, false);
        });
    }

    Livewire.hook("message.processed", function (message, component) {
        initExternalLinkConfirm();
    });

    initExternalLinkConfirm();
});
</script>
