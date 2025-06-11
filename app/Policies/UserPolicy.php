<?php

namespace App\Policies;

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

        return $user->is_owner;
    }

    public function view(User $user, User $model): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if ($model->is($user)) {
            return true;
        }

        if (! $model->isSameOwner($user->owner_id)) {
            return false;
        }

        return $user->is_owner;
    }

    public function create(User $user): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        return $user->is_owner;
    }

    public function update(User $user, User $model): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $model->isSameOwner($user->owner_id)) {
            return false;
        }

        if ($model->is($user)) {
            return false;
        }

        return $user->is_owner;
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

        if (! $model->isSameOwner($user->owner_id)) {
            return false;
        }

        return $user->is_owner;
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

        return $user->is_owner;
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->is($user)) {
            return false;
        }

        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $model->isSameOwner($user->owner_id)) {
            return false;
        }

        return $user->is_owner;
    }
}
