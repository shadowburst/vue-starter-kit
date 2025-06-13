<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain all keys related the the
    | application's various models.
    |
    */

    'banner' => [
        'name' => [
            'one'  => 'banner',
            'many' => 'banners',
        ],
        'fields' => [
            'action'     => 'action',
            'is_enabled' => 'active',
            'message'    => 'message',
            'name'       => 'name',
        ],
    ],

    'media' => [
        'fields' => [

        ],
    ],

    'permission' => [
        'name' => [
            'one'  => 'permission',
            'many' => 'permissions',
        ],
        'fields' => [
            'name' => 'name',
        ],
    ],

    'role' => [
        'name' => [
            'one'  => 'role',
            'many' => 'roles',
        ],
        'fields' => [
            'name' => 'name',
        ],
    ],

    'team' => [
        'name' => [
            'one'  => 'team',
            'many' => 'teams',
        ],
        'fields' => [
            'deleted_at' => 'archived at',
            'is_trashed' => 'is archived',
            'name'       => 'name',
        ],
    ],

    'user' => [
        'name' => [
            'one'  => 'user',
            'many' => 'users',
        ],
        'fields' => [
            'avatar'                => 'avatar',
            'current_password'      => 'current password',
            'deleted_at'            => 'archived at',
            'email'                 => 'email',
            'first_name'            => 'first name',
            'full_name'             => 'full name',
            'is_trashed'            => 'is archived',
            'last_name'             => 'last name',
            'owner'                 => 'owner',
            'password'              => 'password',
            'password_confirmation' => 'confirm password',
            'phone'                 => 'phone',
        ],
        'member' => [
            'name' => [
                'one'  => 'member',
                'many' => 'members',
            ],
            'fields' => [
            ],
        ],
        'default' => [
            'full_name' => 'Deleted user',
        ],
    ],

];
