<?php

namespace App\Services;

class UrlValidator implements UrlValidatorInterface
{
    private const MAX_URL_LENGTH = 2048;
    private const MIN_URL_LENGTH = 10;

    /**
     * Validate URL and return validation result
     *
     * @param string $url The URL to validate
     * @return array{valid: bool, error: string}
     */
    public function validate(string $url): array
    {
        // Check if URL is empty
        if (empty(trim($url))) {
            return ['valid' => false, 'error' => 'URL is required'];
        }

        $url = trim($url);

        // Check URL length
        if (strlen($url) < self::MIN_URL_LENGTH) {
            return ['valid' => false, 'error' => 'URL is too short'];
        }

        if (strlen($url) > self::MAX_URL_LENGTH) {
            return ['valid' => false, 'error' => 'URL is too long'];
        }

        // Add protocol if missing
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = 'https://' . $url;
        }

        // Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return ['valid' => false, 'error' => 'Please enter a valid URL'];
        }

        // Check if URL has valid scheme
        $parsed = parse_url($url);
        if (!isset($parsed['scheme']) || !in_array($parsed['scheme'], ['http', 'https'])) {
            return ['valid' => false, 'error' => 'Only HTTP and HTTPS URLs are allowed'];
        }

        // Check if URL has host
        if (!isset($parsed['host']) || empty($parsed['host'])) {
            return ['valid' => false, 'error' => 'URL must have a valid domain'];
        }

        // Block localhost and private IPs for security
        if ($this->isPrivateUrl($parsed['host'])) {
            return ['valid' => false, 'error' => 'Private URLs are not allowed'];
        }

        return ['valid' => true, 'error' => '', 'normalized_url' => $url];
    }

    /**
     * Check if URL points to private/local network
     */
    private function isPrivateUrl(string $host): bool
    {
        // Check for localhost variations
        if (in_array(strtolower($host), ['localhost', '127.0.0.1', '::1'])) {
            return true;
        }

        // Check for private IP ranges
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return !filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
        }

        return false;
    }
}