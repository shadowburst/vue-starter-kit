<?php

namespace App\Services;

use App\Actions\Media\CreateMedia;
use App\Actions\Media\UpdateMedia;

class MediaService
{
    public function __construct(
        public CreateMedia $create,
        public UpdateMedia $update,
    ) {}
}
