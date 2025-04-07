<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $expires_at
 *
 * @method static \Database\Factories\EmailVerificationTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EmailVerificationToken whereToken($value)
 *
 * @mixin \Eloquent
 */
class EmailVerificationToken extends Model
{
    use HasFactory;

    public $primaryKey = 'email';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'token'      => 'hashed',
        ];
    }
}
