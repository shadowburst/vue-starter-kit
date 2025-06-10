<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait BelongsToCreator
{
    public static function bootBelongsToCreator(): void
    {
        static::creating(function (self $model) {
            $model->{$model->getCreatorIdColumn()} ??= Auth::id();
        });
    }

    public function initializeBelongsToCreator(): void {}

    public function getCreatorIdColumn(): string
    {
        return defined(static::class.'::CREATOR_ID') ? static::CREATOR_ID : 'creator_id';
    }

    public function getQualifiedCreatorIdColumn(): string
    {
        return $this->qualifyColumn($this->getCreatorIdColumn());
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->getCreatorIdColumn())->withDefault([
            'full_name' => __('models.user.default.full_name'),
        ]);
    }

    public function scopeWhereBelongsToCreator(Builder $query, User|int $creator): Builder
    {
        $creator = is_int($creator) ? $creator : $creator->getKey();

        return $query
            ->where($this->getQualifiedCreatorIdColumn(), $creator);
    }
}
