<?php

namespace App\Services;

interface FaviconServiceInterface
{
    /**
     * Get favicon URL for the given URL
     *
     * @param string $url The URL to get favicon for
     * @return string The URL to the favicon service
     */
    public function getFaviconUrl(string $url): string;
}