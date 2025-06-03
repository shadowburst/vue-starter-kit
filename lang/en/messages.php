<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain all keys that can be used in to
    | display to users throughout the lifetime of the application.
    |
    */

    'error' => 'An error occured',

    'banners' => [
        'store' => [
            'success' => 'Banner created successfully',
        ],
        'update' => [
            'success' => 'Banner updated successfully',
        ],
        'enable' => [
            'confirm' => '{1}Are you sure you want to enable this banner ?|[2,*]Are you sure you want to enable these banners ?',
        ],
        'disable' => [
            'confirm' => '{1}Are you sure you want to disable this banner ?|[2,*]Are you sure you want to disable these banners ?',
        ],
        'delete' => [
            'confirm' => '{1}Are you sure you want to delete this banner ?|[2,*]Are you sure you want to delete these banners ?',
            'success' => '{1}Banner deleted successfully|[2,*]Banners deleted successfully',
        ],
    ],

    'settings' => [
        'password' => [
            'update' => [
                'success' => 'Password updated successfully',
            ],
        ],
        'profile' => [
            'update' => [
                'success' => 'Profile updated successfully',
            ],
            'delete' => [
                'success' => 'Profile deleted successfully',
            ],
        ],
    ],

    'users' => [
        'store' => [
            'success' => 'User created successfully',
        ],
        'update' => [
            'success' => 'User updated successfully',
        ],
        'trash' => [
            'confirm' => '{1}Are you sure you want to archive this user ?|[2,*]Are you sure you want to archive these users ?',
            'success' => '{1}User archived successfully|[2,*]Users archived successfully',
        ],
        'restore' => [
            'confirm' => '{1}Are you sure you want to restore this user ?|[2,*]Are you sure you want to restore these users ?',
            'success' => '{1}User restored successfully|[2,*]Users restored successfully',
        ],
        'delete' => [
            'confirm' => '{1}Are you sure you want to delete this user ?|[2,*]Are you sure you want to delete these users ?',
            'success' => '{1}User deleted successfully|[2,*]Users deleted successfully',
        ],
    ],

];
