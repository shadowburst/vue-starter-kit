<?php

namespace App\Policies;

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

        return $user->is_owner;
    }

    public function view(User $user, Team $team): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
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

    public function update(User $user, Team $team): bool
    {
        if ($user->is_admin && Route::is('admin.*')) {
            return true;
        }

        if (! $user->hasTeam($team)) {
            return false;
        }

        return $user->is_owner;
    }

    public function select(User $user, Team $team): bool
    {
        return $user->hasTeam($team);
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

        return $user->is_owner;
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

        return $user->is_owner;
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

        return $user->is_owner;
    }
}
