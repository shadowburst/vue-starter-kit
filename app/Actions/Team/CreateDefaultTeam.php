<?php

namespace App\Actions\Team;

use App\Models\Team;
use Spatie\QueueableAction\QueueableAction;

class CreateDefaultTeam
{
    use QueueableAction;

    public function __construct(
        //
    ) {}

    public function execute(): Team
    {
        return Team::create([
            'name' => __('models.team.default.name'),
        ]);
    }
}
