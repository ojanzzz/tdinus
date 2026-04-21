<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains rate limiting configurations for various parts of
    | the application to prevent abuse and brute force attacks.
    |
    */

    'login' => [
        'max_attempts' => 5,
        'decay_minutes' => 15,
        'lockout_minutes' => 15,
    ],

    'api' => [
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],

    'uploads' => [
        'max_attempts' => 10,
        'decay_minutes' => 1,
    ],

    'general' => [
        'max_attempts' => 100,
        'decay_minutes' => 1,
    ],

];