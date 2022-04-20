<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Actions;

use CauriLand\Foundation\Fortify\Contracts\DeleteUser as Contract;

final class DeleteUser implements Contract
{
    public function delete($user): void
    {
        $user->delete();
    }
}
