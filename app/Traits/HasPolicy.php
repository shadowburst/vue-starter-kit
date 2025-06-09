<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Gate;

trait HasPolicy
{
    public static function bootHasPolicy(): void {}

    public function initializeHasPolicy(): void {}

    protected function canView(): Attribute
    {
        return Attribute::get(fn (): bool => Gate::check('view', $this));
    }

    protected function canUpdate(): Attribute
    {
        return Attribute::get(fn (): bool => Gate::check('update', $this));
    }

    protected function canTrash(): Attribute
    {
        return Attribute::get(fn (): bool => $this->is_trashable && Gate::check('trash', $this));
    }

    protected function canRestore(): Attribute
    {
        return Attribute::get(fn (): bool => $this->is_trashable && Gate::check('restore', $this));
    }

    protected function canDelete(): Attribute
    {
        return Attribute::get(fn (): bool => Gate::check('delete', $this));
    }
}
