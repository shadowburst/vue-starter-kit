<?php

namespace App\Services;

use App\Actions\User\SelectUserTeam;

class UserService
{
    public function __construct(
        public SelectUserTeam $selectTeam,
    ) {}
}
