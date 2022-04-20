@extends('layouts.app', ['fullWidth' => true])

<x-cauri-metadata page="password.reset" />

@section('title')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.page-title" />
@endsection

@section('breadcrumbs')
    <x-cauri-breadcrumbs :crumbs="[
        ['route' => 'login', 'label' => trans('ui::menu.sign_in')],
        ['label' => trans('ui::menu.reset_password')],
    ]" />
@endsection

@section('content')
    <x-data-bag key="fortify-content" resolver="name" view="cauri-fortify::components.component-heading" />

    <livewire:auth.reset-password-form :token="request()->route('token')" :email="old('email', request()->email)" />
@endsection
