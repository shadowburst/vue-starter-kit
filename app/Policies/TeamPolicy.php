<?php

namespace App\Policies;

use App\Enums\Permission\PermissionName;
use App\Enums\Role\RoleName;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class TeamPolicy
{
    public function before(User $user): ?bool
    {
        return null;
    }

    public function viewAny(User $user): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS);
    }

    public function view(User $user, Team $team): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS);
    }

    public function create(User $user): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS) && $user->hasRole(RoleName::EDITOR);
    }

    public function update(User $user, Team $team): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS) && $user->hasRole(RoleName::EDITOR);
    }

    public function select(User $user, Team $team): bool
    {
        return $user->teams()->where($team->getKeyName(), $team->getKey())->exists();
    }

    public function trash(User $user, Team $team): bool
    {
        if ($team->is_trashed) {
            return false;
        }

        if ($user->isSameTeam($team)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS) && $user->hasRole(RoleName::EDITOR);
    }

    public function restore(User $user, Team $team): bool
    {
        if (! $team->is_trashed) {
            return false;
        }

        if ($user->isSameTeam($team)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS) && $user->hasRole(RoleName::EDITOR);
    }

    public function delete(User $user, Team $team): bool
    {
        if ($user->isSameTeam($team)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::TEAMS) && $user->hasRole(RoleName::EDITOR);
    }
}
