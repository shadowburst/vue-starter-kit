<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * @mixin IdeHelperMedia
 */
class Media extends SpatieMedia
{
    use Prunable;

    public function prunable(): Builder
    {
        return static::query()
            ->where('model_type', Relation::getMorphAlias(User::class))
            ->where('collection', User::COLLECTION_TEMP)
            ->where('created_at', '<=', Carbon::now()->subDays(2));
    }
}
