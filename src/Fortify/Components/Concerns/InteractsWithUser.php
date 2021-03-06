<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Components\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * @property ?Authenticatable $user
 */
trait InteractsWithUser
{
    public function getUserProperty(): ?Authenticatable
    {
        return Auth::user();
    }
}
