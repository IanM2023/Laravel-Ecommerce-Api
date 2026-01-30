<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\User;

trait AuthTrait
{
    public function getRoleIdFromAuth(): int
    {
        $userRoleId = auth()->user()->role_id;

        return match ($userRoleId) {
            $this->getAdminRoleId() => $this->getAdminRoleId(),
            $this->getUserRoleId()  => $this->getUserRoleId(),
            default => throw new \Exception('Invalid role'),
        };
    }

    protected function getAdminRoleId(): int
    {
        return Role::where('id', Role::ADMIN)->value('id');
    }

    protected function getUserRoleId(): int
    {
        return Role::where('id', Role::USER)->value('id');
    }
}
