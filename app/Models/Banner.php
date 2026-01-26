<?php

namespace App\Models;

use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperBanner
 */
class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory;

    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'message',
        'action',
        'is_enabled',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var list<string>
     */
    protected $searchable = [
        'name',
        'message',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
        ];
    }

    public static function booted(): void
    {
        static::updated(function (Banner $banner) {
            // Reset users after enabling banner
            if ($banner->wasChanged('is_enabled') && $banner->is_enabled) {
                $banner->users()->sync([]);
            }
        });
    }

    /**
     * The users that have dismissed the banner.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
