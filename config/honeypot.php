<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Honeypot Configuration
    |--------------------------------------------------------------------------
    |
    | Honeypot is a technique to detect and prevent spam bots by adding
    | hidden form fields that should remain empty. Bots often fill all fields.
    |
    */

    'enabled' => env('HONEYPOT_ENABLED', true),

    'field_name' => env('HONEYPOT_FIELD', 'website_url'),

    'field_value' => '',

    'response_message' => 'Spam detected. Please try again.',

    'log_spam' => env('HONEYPOT_LOG_SPAM', true),

    /*
    |--------------------------------------------------------------------------
    | Time-based Protection
    |--------------------------------------------------------------------------
    |
    | Minimum time a form should take to fill (in seconds).
    | Too fast submissions are likely bots.
    |
    */

    'min_time' => env('HONEYPOT_MIN_TIME', 3),

    'time_field' => env('HONEYPOT_TIME_FIELD', 'form_time'),

];