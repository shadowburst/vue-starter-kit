<?php

namespace App\Services;

use App\Data\User\UserAbilitiesResource;
use Illuminate\Support\Facades\Auth;

class AbilitiesService
{
    protected ?UserAbilitiesResource $abilities;

    public function __construct(
        //
    ) {}

    public function get(): UserAbilitiesResource
    {
        return $this->abilities ??= UserAbilitiesResource::from(Auth::user());
    }
}
