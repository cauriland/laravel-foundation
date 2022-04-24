@extends('layouts.app', ['fullWidth' => true])

<x-cauri-metadata page="sign-in"/>

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.page-title"/>
@endsection

@section('breadcrumbs')
    <x-cauri-breadcrumbs :crumbs="[
        ['route' => 'home', 'label' => trans('ui::menu.home')],
        ['label' => trans('ui::menu.sign_in')],
    ]"/>
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.component-heading"/>

    <x:cauri-fortify::form-wrapper :action="route('login')">
        <div class="flex flex-col space-y-5">
            @if (session('status'))
                <x-cauri-alert type="success">
                    {{ session('status') }}
                </x-cauri-alert>
            @endif

            <div class="flex flex-1">
                @php
                    $username = \Laravel\Fortify\Fortify::username();
                    $usernameAlt = Config::get('fortify.username_alt');
                    $type = 'text';

                    if ($usernameAlt) {
                        $label = trans('ui::forms.'.$username).' or '.trans('ui::forms.'.$usernameAlt);
                    } else {
                        $label = trans('ui::forms.'.$username);
                        if ($username === 'email') {
                            $type = 'email';
                        }
                    }
                @endphp

                <x-cauri-input
                    :type="$type"
                    :name="$username"
                    :label="$label"
                    autocomplete="email"
                    class="w-full"
                    :autofocus="true"
                    :value="old($username)"
                    :errors="$errors"
                />
            </div>

            <div class="flex flex-1">
                <x-cauri-password-toggle
                    name="password"
                    :label="trans('ui::forms.password')"
                    autocomplete="password"
                    class="w-full"
                    :errors="$errors"
                />
            </div>

            <x-cauri-checkbox name="remember" :errors="$errors" label-classes="text-base">
                @slot('label')
                    @lang('ui::auth.sign-in.remember_me')
                @endslot
            </x-cauri-checkbox>

            @php($hasForgotPassword = Route::has('password.request'))

            <div
                class="flex flex-col-reverse items-center space-y-4 sm:space-y-0 sm:flex-row {{ $hasForgotPassword ? 'justify-between' : 'justify-end' }}">
                <div>
                    @if($hasForgotPassword)
                        <div class="flex-1 mt-8 sm:mt-0">
                            <a href="{{ route('password.request') }}"
                               class="font-semibold link">@lang('ui::auth.sign-in.forgot_password')</a>
                        </div>
                    @endif
                </div>

                <button type="submit" class="w-full sm:w-auto button-secondary">
                    @lang('ui::actions.sign_in')
                </button>
            </div>
        </div>
    </x:cauri-fortify::form-wrapper>

    @if(Route::has('register'))
        <div class="mb-8 text-center">
            <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.register-now"/>
        </div>
    @endif
@endsection