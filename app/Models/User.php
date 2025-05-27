<?php

namespace App\Models;

use App\Notifications\Auth\ResetPasswordNotification;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Traits\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Spatie\MediaLibrary\HasMedia;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Media|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banner> $banners
 * @property-read int|null $banners_count
 * @property-read mixed $full_name
 * @property-read mixed $initials
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 *
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory;
    use InteractsWithMedia;
    use Notifiable;

    public const string COLLECTION_AVATAR = 'avatar';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function initials(): Attribute
    {
        return Attribute::get(
            fn ($value, array $attributes) => strtoupper("{$attributes['first_name'][0]}{$attributes['last_name'][0]}"),
        );
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(
            fn ($value, array $attributes) => ucwords("{$attributes['first_name']} {$attributes['last_name']}"),
        );
    }

    public function avatar(): MorphOne
    {
        return $this->media()->one()->latestOfMany()->withAttributes('collection_name', static::COLLECTION_AVATAR);
    }

    /**
     * The banners that have been dissmissed by the user.
     */
    public function banners(): BelongsToMany
    {
        return $this->belongsToMany(Banner::class);
    }

    public function routeNotificationForBrevo(?Notification $notification): array|string
    {
        return [$this->email => $this->full_name];
    }

    public function sendEmailVerificationNotification()
    {
        $code = Random::generate(6, '0-9');

        EmailVerificationToken::query()
            ->whereEmail($this->email)
            ->delete();
        EmailVerificationToken::query()
            ->create([
                'email'      => $this->email,
                'token'      => Hash::make($code),
                'expires_at' => now()->addMinutes(30),
            ]);

        $this->notify(new VerifyEmailNotification($code));
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
