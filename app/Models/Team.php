<?php

namespace App\Models;

use App\Data\Team\TeamResource;
use App\Data\Team\TeamSettingsData;
use App\Traits\Models\BelongsToCreator;
use App\Traits\Models\HasPolicy;
use App\Traits\Models\InteractsWithMedia;
use App\Traits\Models\Searchable;
use App\Traits\Models\Trashable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\LaravelData\WithData;
use Spatie\MediaLibrary\HasMedia;

/**
 * @mixin IdeHelperTeam
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
    use WithData;

    protected $dataClass = TeamResource::class;

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
