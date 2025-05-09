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
        'fields' => [
            'name'      => 'name',
            'message'   => 'message',
            'starts_at' => 'from',
            'ends_at'   => 'to',
        ],
    ],

    'email_verification_token' => [
        'fields' => [
            'code' => 'code',
        ],
    ],

    'media' => [
        'fields' => [

        ],
    ],

    'user' => [
        'name' => [
            'one'  => 'user',
            'many' => 'users',
        ],
        'fields' => [
            'first_name'            => 'first name',
            'last_name'             => 'last name',
            'email'                 => 'email',
            'current_password'      => 'current password',
            'password'              => 'password',
            'password_confirmation' => 'confirm password',
            'avatar'                => 'avatar',
        ],
    ],

];
