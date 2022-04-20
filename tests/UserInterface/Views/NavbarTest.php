<?php

declare(strict_types=1);

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;
use function Tests\createAttributes;
use Tests\UserInterface\Mocks\MediaMock;

it('should render the component', function (): void {
    Route::view('/', 'cauri::navbar.hamburger')->name('home');
    Route::view('/post', 'cauri::navbar.hamburger')->name('post');

    $this
        ->actingAs(new User())
        ->assertView('cauri::navbar', createAttributes([
            'title'      => 'Explorer',
            'navigation' => [
                [
                    'route'    => 'home',
                    'label'    => 'Home',
                    'children' => [
                        ['route' => 'post', 'label' => 'Post'],
                    ],
                ],
            ],
            'profilePhoto'     => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'      => [],
            'profileMenuClass' => 'unicorn',
        ]))
        ->contains('http://localhost/post')
        ->contains('src="https://imgur.com/abc123"')
        ->contains('unicorn');
});
