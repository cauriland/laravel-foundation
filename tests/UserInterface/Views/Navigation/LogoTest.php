<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use function Tests\createAttributes;

it('should render the component', function (): void {
    Route::view('/', 'cauri::navbar.logo')->name('home');

    $this
        ->assertView('cauri::navbar.logo', createAttributes([
            'title' => 'Explorer',
        ]))
        ->contains('<div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">CAURI</span> Explorer</div>');
});

it('should render the [logo] slot', function (): void {
    Route::view('/', 'cauri::navbar.logo')->name('home');

    $this
        ->assertView('cauri::navbar.logo', createAttributes([
            'logo' => 'custom-logo',
        ]))
        ->contains('custom-logo');
});
