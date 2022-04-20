@extends('layouts.app', ['fullWidth' => true])

<x-cauri-metadata page="two-factor.login" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-cauri-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.2fa')],
    ]" />
@endsection

@section('content')
    <x:cauri-fortify::component-heading :title="trans('ui::auth.two-factor.page_header')" :description="trans('ui::auth.two-factor.page_description')" />

    <div x-data="{ recovery: @json($errors->has('recovery_code')) }" x-cloak>
        @include('cauri-fortify::auth.two-factor.form')
        @include('cauri-fortify::auth.two-factor.recovery-form')
    </div>
@endsection
