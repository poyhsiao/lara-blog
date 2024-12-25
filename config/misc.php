<?php

return [
    'admin' => [
        'email' => env('MISC_ADMIN_EMAIL', 'admin@example.com'),
        'name' => env('MISC_ADMIN_NAME', 'Admin'),
    ],

    'redirect' => [
        'email_verified' => env('REDIRECT_EMAIL_VERIFIED', '/email/verified'),
        'forget_password' => env('REDIRECT_FORGET_PASSWORD', '/forget-password'),
    ],
];
