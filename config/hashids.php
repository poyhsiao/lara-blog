<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => env('HASH_MAIN_SALT', 'main'),
            'length' => (int)env('HASH_MAIN_LENGTH', 10),
            'alphabet' => env('HASH_MAIN_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
        ],

        'alternative' => [
            'salt' => env('HASH_ALTERNATIVE_SALT', 'your-salt-string'),
            'length' => (int)env('HASH_ALTERNATIVE_LENGTH', 8),
            'alphabet' => env('HASH_ALTERNATIVE_ALPHABET', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
        ],

        /**
         * User ID Hash
         */
        'users' => [
            'salt' => env('HASH_USERS_SALT', 'userid'),
            'length' => (int)env('HASH_USERS_LENGTH', 10),
            'alphabet' => env('HASH_USERS_ALPHABET', 'abcdefghijklmnopqrstuvwxyz1234567890'),
        ],

        'posts' => [
            'salt' => env('HASH_POSTS_SALT', 'postid'),
            'length' => (int)env('HASH_POSTS_LENGTH', 10),
            'alphabet' => env('HASH_POSTS_ALPHABET', 'abcdefghijklmnopqrstuvwxyz1234567890'),
        ],

        'email-validate' => [
            'salt' => env('HASH_EMAIL_VALIDATE_SALT', 'email-validate'),
            'length' => (int)env('HASH_EMAIL_VALIDATE_LENGTH', 10),
            'alphabet' => env('HASH_EMAIL_VALIDATE_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),
        ],

        'default_set' => env('HASH_DEFAULT_SET', 'base62'),

        'alphabet_set' => [
            'uppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',

            'lowercase' => 'abcdefghijklmnopqrstuvwxyz',

            'sn' => 'abcdefghijklmnopqrstuvwxyz1234567890',

            'base64url' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789._-',

            'base62' => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            'base58btc' => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz',

            'base32hex' => '0123456789abcdefghjkmnpqrstuvwxyz',

            'base32' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567',

            'base16hex' => '0123456789abcdef',

            'base8' => '01234567',
        ],
    ],

];
