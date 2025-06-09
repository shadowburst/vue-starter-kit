<?php

namespace App\Models\Scopes;

use App\Models\User;
use App\Traits\BelongsToOwner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BelongsToAuthOwner implements Scope
{
    public function apply(Builder $query, Model $model): Builder
    {
        if (! in_array(BelongsToOwner::class, class_uses_recursive($model::class))) {
            return $query;
        }

        if (App::runningInConsole()) {
            return $query;
        }

        if (Route::is('admin.*')) {
            return $query;
        }

        if ($model instanceof User) {
            return $query;
        }

        $user = Auth::user();

        if (! $user) {
            return $query;
        }

        return $query->whereBelongsToOwner($user);
    }

    public function extend(Builder $query)
    {
        $query->macro(
            'belongsToAnyOwner',
            fn (Builder $q) => $q->withoutGlobalScope($this),
        );
    }
}
