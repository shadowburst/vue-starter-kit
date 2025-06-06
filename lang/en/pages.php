<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pages Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain all keys that are used by specific
    | pages in the application.
    |
    */

    'admin' => [
        'title' => 'Dashboard',
    ],

    'auth' => [
        'confirm_password' => [
            'title'       => 'Confirm your password',
            'description' => 'This is a secure area of the application. Please confirm your password before continuing.',
            'action'      => 'Confirm password',
        ],
        'forgot_password' => [
            'title'       => 'Forgot password',
            'description' => 'Enter your email to receive a password reset link',
            'email_link'  => 'Email password reset link',
            'return_to'   => 'Or, return to',
        ],
        'login' => [
            'title'           => 'Log in to your account',
            'description'     => 'Enter your email and password below to log in',
            'forgot_password' => 'Forgot password ?',
            'remember_me'     => 'Remember me',
            'no_account'      => "Don't have an account ?",
            'action'          => 'Log in',
        ],
        'register' => [
            'title'       => 'Create an account',
            'description' => 'Enter your details below to create your account',
            'action'      => 'Create account',
            'has_account' => 'Already have an account ?',
        ],
        'reset_password' => [
            'title'       => 'Reset password',
            'description' => 'Please enter your new password below',
            'action'      => 'Reset password',
        ],
        'verify_email' => [
            'title'        => 'Verify email',
            'description'  => 'Please verify your email address with the code we emailed you.',
            'resend_email' => 'Resend verification email',
            'not_you'      => 'Not you ?',
        ],
    ],

    'banners' => [
        'admin' => [
            'index' => [
                'title' => 'Banners',
            ],
            'create' => [
                'title'       => 'Create a banner',
                'description' => 'Create a new banner to display on the site',
            ],
            'edit' => [
                'title'       => 'Update a banner',
                'description' => 'Update a banner to display on the site',
            ],
        ],
    ],

    'index' => [
        'title' => 'Dashboard',
    ],

    'settings' => [
        'title'   => 'Settings',
        'profile' => [
            'title'       => 'Profile settings',
            'information' => [
                'title'            => 'Profile information',
                'description'      => 'Update your name and email address',
                'unverified_email' => 'Your email address is unverified.',
                'verify_email'     => 'Click here to verify.',
            ],
            'delete' => [
                'title'       => 'Delete account',
                'description' => 'This action is irreversible',
            ],
        ],
        'security' => [
            'title'    => 'Security settings',
            'password' => [
                'title'       => 'Password',
                'description' => 'Ensure your account is using a long, random password to stay secure',
            ],
        ],
        'appearance' => [
            'title'       => 'Appearance settings',
            'description' => "Update your account's appearance settings",
            'colors'      => [
                'light' => 'Light',
                'auto'  => 'System',
                'dark'  => 'Dark',
            ],
        ],
    ],

    'teams' => [
        'index' => [
            'title' => 'Teams',
        ],
        'create' => [
            'title'       => 'Create a team',
            'description' => 'Create a new team for you and your users',
        ],
        'edit' => [
            'title'       => 'Update a team',
            'description' => "Update a team's details",
        ],
    ],

    'users' => [
        'index' => [
            'title' => 'Users',
        ],
        'create' => [
            'title'       => 'Create a user',
            'description' => 'Create a new user for the site',
        ],
        'edit' => [
            'title'       => 'Update a user',
            'description' => "Update a user's details",
        ],
    ],

];
