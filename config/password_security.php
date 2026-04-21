<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Password Security Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains password security configurations to ensure
    | strong passwords and prevent common attacks.
    |
    */

    'policies' => [
        'admin' => [
            'min_length' => 12,
            'require_uppercase' => true,
            'require_lowercase' => true,
            'require_numbers' => true,
            'require_symbols' => true,
            'prevent_common' => true,
            'prevent_pwned' => true,
        ],

        'member' => [
            'min_length' => 8,
            'require_uppercase' => true,
            'require_lowercase' => true,
            'require_numbers' => true,
            'require_symbols' => true,
            'prevent_common' => true,
            'prevent_pwned' => false, // Less strict for members
        ],
    ],

    'common_passwords' => [
        'password', '123456', '123456789', 'qwerty', 'abc123',
        'password123', 'admin', 'letmein', 'welcome', 'monkey',
        '1234567890', 'iloveyou', 'princess', 'rockyou', '1234567',
        '12345678', 'password1', '123123', 'football', 'baseball',
        'welcome1', 'admin123', 'user', 'test', 'guest',
    ],

    'lockout' => [
        'max_attempts' => 5,
        'decay_minutes' => 15,
        'lockout_minutes' => 15,
    ],

];