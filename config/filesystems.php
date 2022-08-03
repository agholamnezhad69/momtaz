<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'storage_root_address'),
//    'default' => env('FILESYSTEM_DRIVER', 'public_html'),

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    'disks' => [

        'public_html' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => ''
        ],
        'storage_root_address' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'storage_private' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
//           'url' => env('APP_URL') . '/images',
            'url' => '/'
        ],
        'storage_public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],
        // ftp
        'download_host' => [
            'driver' => 'ftp',
            'host' => 'ftp.dd-wrt.com',
            'username' => 'anonymous',
            'passive' => true,
            'timeout' => 30,
        ],

//        's3' => [
//            'driver' => 's3',
//            'key' => env('AWS_ACCESS_KEY_ID'),
//            'secret' => env('AWS_SECRET_ACCESS_KEY'),
//            'region' => env('AWS_DEFAULT_REGION'),
//            'bucket' => env('AWS_BUCKET'),
//            'url' => env('AWS_URL'),
//        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
