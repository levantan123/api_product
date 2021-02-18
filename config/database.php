<?php

return [
    'default' => env('DB_CONNECTION', 'mongodb'),
    'connections'=>[
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => 'localhost',
            'port' => 27017,
            'database' => 'api_product',
            'username' => '',
            'password' => '',
            'options' => [
                // here you can pass more settings to the Mongo Driver Manager
                // see https://www.php.net/manual/en/mongodb-driver-manager.construct.php under "Uri Options" for a list of complete parameters that you can use

                //'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'), // required with Mongo 3+
            ],
        ],
    ]
];
