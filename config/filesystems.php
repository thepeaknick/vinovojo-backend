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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'news' => [
            'driver' => 'local',
            'root' => storage_path('app/news'),
            'visibility' => 'public',
            'url' => url('news')
        ],

        'events' => [
            'driver' => 'local',
            'root' => storage_path('app/events'),
            'visibility' => 'public',
            'url' => url('events')
        ],

        'wines' => [
            'driver' => 'local',
            'root' => storage_path('app/wines'),
            'visibility' => 'public',
            'url' => url('wines')
        ],

        'wineries' => [
            'driver' => 'local',
            'root' => storage_path('app/wineries'),
            'visibility' => 'public',
            'url' => url('storage/app/wineries')
        ],

        'paths' => [
            'driver' => 'local',
            'root' => storage_path('app/paths'),
            'visibility' => 'public',
            'url' => url('paths')
        ],

        'areas' => [
            'driver' => 'local',
            'root' => storage_path('app/areas'),
            'visibility' => 'public',
            'url' => url('areas')
        ],

        'rates' => [
            'driver' => 'local',
            'root' => storage_path('app/rates'),
            'visibility' => 'public',
            'url' => url('rates')
        ],

        'pois' => [
            'driver' => 'local',
            'root' => storage_path('app/pois'),
            'visibility' => 'public',
            'url' => url('pois')
        ],

        'socials' => [
            'driver' => 'local',
            'root' => storage_path('app/socials'),
            'visibility' => 'public',
            'url' => url('pois')
        ],

    ],

];
