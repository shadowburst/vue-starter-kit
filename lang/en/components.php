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

    'settings' => [
        'account' => [
            'delete_dialog' => [
                'title'                => 'Are you sure you want to delete your account?',
                'description'          => 'Once your account is deleted, all of its resources and data will also be permanently deleted.',
                'password_description' => 'Please enter your password to confirm you would like to permanently delete your account.',
                'action'               => 'Delete your account',
            ],
        ],
    ],

    'ui' => [
        'custom' => [
            'alert_drawer' => [
                'title' => [
                    'default'     => 'Confirm',
                    'destructive' => 'Warning',
                ],
            ],
            'combobox' => [
                'selected' => '1 item selected|:count items selected',
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
            'field' => [
                'media' => [
                    'upload' => 'Upload a file',
                    'delete' => 'Remove file',
                ],
            ],
            'multi_select' => [
                'empty'    => 'nothing to display',
                'reset'    => 'reset',
                'selected' => '1 selected|:count selected',
            ],
        ],
    ],
];
