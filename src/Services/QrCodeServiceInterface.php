<?php

namespace App\Services;

interface QrCodeServiceInterface
{
    /**
     * Generate a QR code for the given URL and return as a data URL
     *
     * @param string $url The URL to encode in the QR code
     * @return string The data URL containing the QR code image
     */
    public function generateQrCodeUrl(string $url): string;
}