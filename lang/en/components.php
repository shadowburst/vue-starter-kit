<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Components Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain all keys that are used by specific
    | components in the application.
    |
    */

    'app' => [
        'alert_dialog' => [
            'title' => [
                'default'     => 'Confirm',
                'success'     => 'Confirm',
                'warning'     => 'Warning',
                'destructive' => 'Warning',
            ],
        ],
        'user_dropdown' => [
            'settings' => 'Settings',
            'logout'   => 'Log out',
        ],
    ],

    'settings' => [
        'profile' => [
            'delete_dialog' => [
                'title'       => 'Are you sure you want to delete your account?',
                'description' => 'Once your account is deleted, all of its resources and data will also be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.',
                'action'      => 'Delete your account',
            ],
        ],
    ],

    'ui' => [
        'custom' => [
            'combobox' => [
                'selected' => '{1}1 item selected|[2,*]:count items selected',
                'empty'    => 'nothing to display',
            ],
            'data_table' => [
                'selected'      => ':selected of :rows row(s) selected',
                'empty'         => 'nothing to display',
                'rows_per_page' => 'rows per page',
                'pages'         => 'page :current of :total',
            ],
            'filters' => [
                'sheet' => [
                    'title'       => 'Filter the list',
                    'description' => 'Get only the items you need',
                ],
            ],
            'input' => [
                'media' => [
                    'upload' => 'Upload a file',
                    'delete' => 'Remove file',
                ],
            ],
        ],
    ],
];
