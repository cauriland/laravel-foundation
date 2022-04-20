@extends('layouts.app', ['fullWidth' => true])

<x-cauri-metadata page="sign-up" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-cauri-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.sign_up')],
    ]" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.component-heading" />

    <livewire:auth.register-form />

    <div class="text-center">
        <div class="mb-8">
            @lang('ui::auth.register-form.already_member', ['route' => route('login')])
        </div>
    </div>
@endsection
