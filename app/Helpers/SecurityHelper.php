<?php

if (!function_exists('validateSecurePassword')) {
    /**
     * Validate password against security policies.
     *
     * @param string $password
     * @param string $role
     * @return array
     */
    function validateSecurePassword(string $password, string $role = 'member'): array
    {
        $policies = config('password_security.policies.' . $role, config('password_security.policies.member'));
        $errors = [];

        // Check minimum length
        if (strlen($password) < $policies['min_length']) {
            $errors[] = "Password must be at least {$policies['min_length']} characters long.";
        }

        // Check for uppercase
        if ($policies['require_uppercase'] && !preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        // Check for lowercase
        if ($policies['require_lowercase'] && !preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        // Check for numbers
        if ($policies['require_numbers'] && !preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        // Check for symbols
        if ($policies['require_symbols'] && !preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }

        // Check against common passwords
        if ($policies['prevent_common'] && in_array(strtolower($password), config('password_security.common_passwords'))) {
            $errors[] = 'This password is too common. Please choose a more unique password.';
        }

        // Check password strength score
        $strength = calculatePasswordStrength($password);
        if ($strength < 3) {
            $errors[] = 'Password is too weak. Please use a stronger password.';
        }

        return $errors;
    }
}

if (!function_exists('calculatePasswordStrength')) {
    /**
     * Calculate password strength score (0-4).
     *
     * @param string $password
     * @return int
     */
    function calculatePasswordStrength(string $password): int
    {
        $score = 0;
        $length = strlen($password);

        // Length scoring
        if ($length >= 8) $score++;
        if ($length >= 12) $score++;
        if ($length >= 16) $score++;

        // Character variety scoring
        if (preg_match('/[a-z]/', $password)) $score += 0.5;
        if (preg_match('/[A-Z]/', $password)) $score += 0.5;
        if (preg_match('/[0-9]/', $password)) $score += 0.5;
        if (preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) $score += 0.5;

        return min(4, (int) $score);
    }
}

if (!function_exists('sanitizeInput')) {
    /**
     * Sanitize user input to prevent XSS and injection attacks.
     *
     * @param string $input
     * @return string
     */
    function sanitizeInput(string $input): string
    {
        // Remove null bytes
        $input = str_replace("\0", '', $input);

        // Trim whitespace
        $input = trim($input);

        // Remove potentially dangerous HTML
        $input = strip_tags($input);

        // Convert special characters to HTML entities
        $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Limit length
        if (strlen($input) > 10000) {
            $input = substr($input, 0, 10000);
        }

        return $input;
    }
}