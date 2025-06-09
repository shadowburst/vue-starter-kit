<?php

namespace App\Policies;

use App\Enums\Permission\PermissionName;
use App\Enums\Role\RoleName;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class UserPolicy
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

        return $user->hasPermissionTo(PermissionName::USERS);
    }

    public function view(User $user, User $model): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if ($model->is($user)) {
            return true;
        }

        if (! $model->isSameOwner($user->id)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::USERS);
    }

    public function create(User $user): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        return $user->hasPermissionTo(PermissionName::USERS) && $user->hasRole(RoleName::EDITOR);
    }

    public function update(User $user, User $model): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if ($model->is($user)) {
            return true;
        }

        if (! $model->isSameOwner($user->id)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::USERS) && $user->hasRole(RoleName::EDITOR);
    }

    public function trash(User $user, User $model): bool
    {
        if ($model->is_trashed) {
            return false;
        }

        if ($model->is($user)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $model->isSameOwner($user->id)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::USERS) && $user->hasRole(RoleName::EDITOR);
    }

    public function restore(User $user, User $model): bool
    {
        if (! $model->is_trashed) {
            return false;
        }

        if ($model->is($user)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $model->isSameOwner($user->id)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::USERS) && $user->hasRole(RoleName::EDITOR);
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->is($user)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $model->isSameOwner($user->id)) {
            return false;
        }

        return $user->hasPermissionTo(PermissionName::USERS) && $user->hasRole(RoleName::EDITOR);
    }
}
