<?php

namespace App\Models;

class QrCodeModel
{
    /**
     * Generate a QR code URL for the given URL
     *
     * @param string $url The URL to encode in the QR code
     * @return string The URL to the generated QR code
     */
    public function generateQrCodeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }
        
        // A free QR code API
        return 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($url);
    }
}