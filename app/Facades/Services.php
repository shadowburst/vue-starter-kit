<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Services\AbilitiesService abilities()
 * @method static \App\Services\MediaService media()
 * @method static \App\Services\SettingsService settings()
 * @method static \App\Services\TeamService team()
 * @method static \App\Services\ToastService toast()
 * @method static \App\Services\UserService user()
 */
class Services extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'services';
    }
}
