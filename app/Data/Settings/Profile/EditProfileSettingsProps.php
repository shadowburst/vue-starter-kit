<?php

namespace App\Data\Settings\Profile;

use Spatie\LaravelData\Resource;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class EditProfileSettingsProps extends Resource
{
    public function __construct(
        public bool $mustVerifyEmail,
    ) {}
}
