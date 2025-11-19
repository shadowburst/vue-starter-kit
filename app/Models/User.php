<?php

namespace App\Models;

use App\Notifications\Auth\ResetPasswordNotification;
use App\Traits\BelongsToCreator;
use App\Traits\HasPolicy;
use App\Traits\HasRoles;
use App\Traits\HasTeams;
use App\Traits\InteractsWithMedia;
use App\Traits\Searchable;
use App\Traits\Trashable;
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
use Spatie\MediaLibrary\HasMedia;
use Spatie\OneTimePasswords\Models\Concerns\HasOneTimePasswords;

/**
 * @property int $id
 * @property bool $is_admin
 * @property int $owner_id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string|null $phone
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property int|null $creator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property int|null $team_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $activeMembers
 * @property-read int|null $active_members_count
 * @property-read \App\Models\Media|null $avatar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Banner> $banners
 * @property-read int|null $banners_count
 * @property-read User|null $creator
 * @property-read bool $is_editor
 * @property-read bool $is_member
 * @property-read bool $is_owner
 * @property-read true $is_trashable
 * @property bool $is_trashed
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\OneTimePasswords\Models\OneTimePassword> $oneTimePasswords
 * @property-read int|null $one_time_passwords_count
 * @property-read User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read array $policy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $trashedTeams
 * @property-read int|null $trashed_teams_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User editors()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User filterTrashed(\App\Enums\Trashed\TrashedFilter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User members()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User owners()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User search(?string $q)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBelongsToCreator(\App\Models\User|int $creator)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBelongsToOwner(\App\Models\User|int $owner)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBelongsToTeam(\App\Models\Team|int $team)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 *
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use BelongsToCreator;
    use HasFactory;
    use HasOneTimePasswords;
    use HasPolicy;
    use HasRoles;
    use HasTeams;
    use InteractsWithMedia;
    use Notifiable;
    use Searchable;
    use Trashable;

    const string COLLECTION_AVATAR = 'avatar';

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
