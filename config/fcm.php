<?php
/**
 * Here are keys for Firebase FCM Push notifications
 */
return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAGVtC9No:APA91bHluLVOt09dbKoyz482eIvZCHyP6WW4iTGoCfYiphwVShr35Gr2vXp7c5AKdopAXr6lWxMSWaD1QSj8a2rV8oeTXyY_7zT6mmPgAaRDI6SMGvoNXqqPAFf9EH11mE-39wYxtpo0'),
        'sender_id' => env('FCM_SENDER_ID', '108905297114'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
