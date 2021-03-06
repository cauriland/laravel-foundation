<?php

declare(strict_types=1);

use CauriLand\Foundation\Fortify\Actions\DeleteUser;
use CauriLand\Foundation\Fortify\Models\User;

it('should delete a user', function () {
    $user = User::create([
        'name'     => 'John Doe',
        'username' => 'johndoe',
        'email'    => 'john@doe.com',
        'password' => 'password',
    ]);

    expect(User::find($user->id)->id)->toBe($user->id);

    (new DeleteUser())->delete($user);

    expect(User::find($user->id))->toBeNull();
});
