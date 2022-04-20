<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy
{
    use HandlesAuthorization;

    protected string $resourceName;
}
