@extends('layouts.app', ['fullWidth' => true])

<x-cauri-metadata page="password.reset"/>

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.page-title"/>
@endsection

@section('breadcrumbs')
    <x-cauri-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.password_reset_email')],
    ]"/>
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.component-heading"/>

    <div class="py-8 mx-auto space-y-8 max-w-xl">
        <x-cauri-flash />

        <x:cauri-fortify::form-wrapper class="sm:max-w-xl" :action="route('password.email')">
            <div class="mb-8">
                <div class="flex flex-1">
                    <x-cauri-input
                        type="email"
                        name="email"
                        label="Email"
                        autocomplete="email"
                        class="w-full"
                        :autofocus="true"
                        :required="true"
                    />
                </div>
            </div>

            <div class="flex flex-col-reverse justify-between items-center space-y-4 md:flex-row md:space-y-0">
                <div class="flex-1 mt-8 md:mt-0">
                    <a href="{{ route('login') }}" class="link">@lang('ui::actions.cancel')</a>
                </div>

                <button type="submit" class="w-full md:w-auto button-secondary">
                    @lang('ui::auth.forgot-password.reset_link')
                </button>
            </div>
        </x:cauri-fortify::form-wrapper>
    </div>
@endsection
