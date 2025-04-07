<?php

namespace App\Services;

use App\Actions\Media\StoreMedia;
use App\Actions\Media\UpdateOneMedia;

class MediaService
{
    public function __construct(
        public StoreMedia $store,
        public UpdateOneMedia $updateOne,
    ) {}
}
