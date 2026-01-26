<?php

namespace App\Models;

use App\Data\User\UserResource;
use App\Notifications\Auth\ResetPasswordNotification;
use App\Traits\Models\BelongsToCreator;
use App\Traits\Models\BelongsToTeam;
use App\Traits\Models\HasPolicy;
use App\Traits\Models\HasRoles;
use App\Traits\Models\HasTeams;
use App\Traits\Models\InteractsWithMedia;
use App\Traits\Models\Searchable;
use App\Traits\Models\Trashable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use Spatie\LaravelData\WithData;
use Spatie\MediaLibrary\HasMedia;
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use BelongsToCreator;
    use BelongsToTeam;
    use HasFactory;
    use HasOneTimePasswords;
    use HasPolicy;
    use HasRoles;
    use HasTeams;
    use InteractsWithMedia;
    use Notifiable;
    use Searchable;
    use Trashable;
    use WithData;

    protected $dataClass = UserResource::class;

    const string COLLECTION_AVATAR = 'avatar';

    const string COLLECTION_TEMP = 'temp';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'is_admin',
        'owner_id',
        'team_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_confirmed_at',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var list<string>
     */
    protected $searchable = [
        'full_name',
        'phone',
        'email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_admin'          => 'boolean',
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public static function booted(): void
    {
        static::creating(function (User $user) {
            $user->remember_token ??= Str::random(10);
        });
    }

    public function avatar(): MorphOne
    {
        return $this->media()->one()
            ->latestOfMany()
            ->withAttributes('collection_name', static::COLLECTION_AVATAR);
    }

    /**
     * The banners that have been dissmissed by the user.
     */
    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(Banner::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class, $this->getOwnerIdColumn())->whereBelongsToAnyTeam();
    }

    public function activeMembers(): HasMany
    {
        return $this->members()->withAttributes($this->getDeletedAtColumn(), null);
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): string => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value): string => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(
            fn (?string $value): string => trim($value ? ucwords($value) : "{$this->first_name} {$this->last_name}"),
        );
    }

    public function routeNotificationForBrevo(?Notification $notification): array|string
    {
        return [$this->email => $this->full_name];
    }

    public function sendEmailVerificationNotification()
    {
        $this->sendOneTimePassword();
    }

    public function sendPasswordResetNotification(#[\SensitiveParameter] $token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION_AVATAR)
            ->acceptsMimeTypes(['image/jpeg', 'image/png'])
            ->singleFile();
    }
}
