<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Data Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain all keys related to particular
    | data objects.
    |
    */

    'address' => [
        'name' => [
            'one'  => 'address',
            'many' => 'addresses',
        ],
        'fields' => [
            'line_1'      => 'line 1',
            'line_2'      => 'line 2',
            'postal_code' => 'postal code',
            'city'        => 'city',
            'country'     => 'country',
            'lat'         => 'lat',
            'lng'         => 'lng',
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
            'full_name'             => 'full name',
            'email'                 => 'email',
            'phone'                 => 'phone',
            'current_password'      => 'current password',
            'password'              => 'password',
            'password_confirmation' => 'confirm password',
            'avatar'                => 'avatar',
        ],
    ],

];
