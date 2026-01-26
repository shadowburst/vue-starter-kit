<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Gate;

trait HasPolicy
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $policies = [
        'view',
        'update',
        'delete',
    ];

    public static function bootHasPolicy(): void {}

    public function initializeHasPolicy(): void
    {
        if ($this->is_trashable) {
            $this->policies[] = 'trash';
            $this->policies[] = 'restore';
        }
    }

    public function getPolicies(): array
    {
        return $this->policies;
    }

    protected function policy(): Attribute
    {
        return Attribute::get(
            fn (): array => collect($this->getPolicies())
                ->mapWithKeys(fn (string $permission) => [$permission => Gate::check($permission, $this)])
                ->toArray(),
        );
    }
}
