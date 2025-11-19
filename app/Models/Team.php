<?php

namespace App\Models;

use App\Data\Team\TeamSettingsData;
use App\Traits\BelongsToCreator;
use App\Traits\HasPolicy;
use App\Traits\InteractsWithMedia;
use App\Traits\Searchable;
use App\Traits\Trashable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property int $id
 * @property int|null $creator_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Spatie\LaravelData\Contracts\BaseData|\Spatie\LaravelData\Contracts\TransformableData|null $settings
 * @property-read \App\Models\User|null $creator
 * @property-read true $is_trashable
 * @property bool $is_trashed
 * @property-read \App\Models\Media|null $logo
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read array $policy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 *
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static Builder<static>|Team filterTrashed(\App\Enums\Trashed\TrashedFilter $filter)
 * @method static Builder<static>|Team newModelQuery()
 * @method static Builder<static>|Team newQuery()
 * @method static Builder<static>|Team onlyTrashed()
 * @method static Builder<static>|Team query()
 * @method static Builder<static>|Team search(?string $q)
 * @method static Builder<static>|Team whereBelongsToCreator(\App\Models\User|int $creator)
 * @method static Builder<static>|Team whereCreatedAt($value)
 * @method static Builder<static>|Team whereCreatorId($value)
 * @method static Builder<static>|Team whereDeletedAt($value)
 * @method static Builder<static>|Team whereId($value)
 * @method static Builder<static>|Team whereName($value)
 * @method static Builder<static>|Team whereSettings($value)
 * @method static Builder<static>|Team whereUpdatedAt($value)
 * @method static Builder<static>|Team withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Team withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Team extends Model implements HasMedia
{
    use BelongsToCreator;

    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    use HasPolicy;
    use InteractsWithMedia;
    use Searchable;
    use Trashable;

    const string COLLECTION_LOGO = 'logo';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'creator_id',
        'name',
        'settings',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var list<string>
     */
    protected $searchable = [
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => TeamSettingsData::class,
        ];
    }

    public static function booted(): void {}

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_roles')
            ->distinct([app(User::class)->getQualifiedKeyName()]);
    }

    public function logo(): MorphOne
    {
        return $this->media()->one()
            ->latestOfMany()
            ->withAttributes('collection_name', static::COLLECTION_LOGO);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION_LOGO)
            ->acceptsMimeTypes(['image/svg+xml'])
            ->singleFile();
    }
}
