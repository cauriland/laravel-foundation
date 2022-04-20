<x:cauri-fortify::form-wrapper :action="$formUrl" x-data="{isTyping: false}">
    @if($invitation)
        <input type="hidden" name="name" value="{{ $invitation->name }}" />
        <input type="hidden" name="email" value="{{ $invitation->email }}" />
    @endif

    <div class="space-y-5">
        @if(Config::get('fortify.username_alt'))
            <div>
                <div class="flex flex-1">
                    <x-cauri-input
                        model="username"
                        type="text"
                        name="username"
                        :label="trans('ui::forms.username')"
                        autocomplete="username"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>
        @endif

        @unless($invitation)
            <div>
                <div class="flex flex-1">
                    <x-cauri-input
                        model="name"
                        name="name"
                        :label="trans('ui::forms.display_name')"
                        autocomplete="name"
                        class="w-full"
                        :autofocus="true"
                        :errors="$errors"
                    />
                </div>
            </div>

            <div>
                <div class="flex flex-1">
                    <x-cauri-input
                        model="email"
                        type="email"
                        name="email"
                        :label="trans('ui::forms.email')"
                        autocomplete="email"
                        class="w-full"
                        :errors="$errors"
                    />
                </div>
            </div>
        @endunless

        <x:cauri-fortify::password-rules
            :password-rules="$passwordRules"
            is-typing="isTyping"
            rules-wrapper-class="grid grid-cols-1 gap-4 my-4"
            @typing="isTyping=true"
        >
            <x-cauri-password-toggle
                model="password"
                name="password"
                :label="trans('ui::forms.password')"
                autocomplete="new-password"
                class="w-full"
                :errors="$errors"
            />
        </x:cauri-fortify::password-rules>

        <div>
            <div class="flex flex-1">
                <x-cauri-password-toggle
                    model="password_confirmation"
                    name="password_confirmation"
                    :label="trans('ui::forms.confirm_password')"
                    autocomplete="new-password"
                    class="w-full"
                    :errors="$errors"
                />
            </div>
        </div>

        <div>
            <x-cauri-checkbox
                model="terms"
                name="terms"
                :errors="$errors"
            >
                @slot('label')
                    @lang('ui::auth.register-form.conditions', ['termsOfServiceRoute' => route('terms-of-service'), 'privacyPolicyRoute' => route('privacy-policy')])
                @endslot
            </x-cauri-checkbox>

            @error('terms')
                <p class="input-help--error">{{ $message }}</p>
            @enderror
        </div>

        <div class="text-right">
            <button
                type="submit"
                class="w-full sm:w-auto button-secondary"
                @unless ($this->canSubmit()) disabled @endunless
            >
                @lang('ui::actions.sign_up')
            </button>
        </div>
    </div>
</x:cauri-fortify::form-wrapper>
