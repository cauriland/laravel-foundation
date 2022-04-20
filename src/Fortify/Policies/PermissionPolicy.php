<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Policies;

use CauriLand\Foundation\Fortify\Contracts\UserRole;
use CauriLand\Foundation\Fortify\Models\Permission;

class PermissionPolicy
{
    public function viewAny($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function view($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function create($user)
    {
        return $this->isSuperAdmin($user);
    }

    public function update($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function delete($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function restore($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    public function forceDelete($user, Permission $permission)
    {
        return $this->isSuperAdmin($user);
    }

    private function isSuperAdmin($user): bool
    {
        return $user->hasRole([
            app(UserRole::class)::SUPER_ADMIN,
        ]);
    }
}
