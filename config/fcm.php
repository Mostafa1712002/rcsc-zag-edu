<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => 'AAAArlLFhmE:APA91bEbagOb4bGEoTO7iktM7UoCohlIKWTfK6AAkh7yRL7sSoUaXcLixB_GXA3SxLg1I0aSLOrwU4GoZhPa5x0kCGge2QsYXflfuWy1ErOM5AkhxlUqMDupGtD5XVpAluC6bflDTpDi',
        'sender_id' => '748712986209',
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
