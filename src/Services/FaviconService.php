<?php

namespace App\Services;

class FaviconService implements FaviconServiceInterface
{
    /**
     * Get favicon URL for the given URL
     *
     * @param string $url The URL to get favicon for
     * @return string The URL to Google's favicon service
     */
    public function getFaviconUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        return 'https://www.google.com/s2/favicons?domain=' . urlencode($url) . '&sz=64';
    }
}