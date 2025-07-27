<?php

namespace App\Models;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class QrCodeModel
{
    /**
     * Generate a QR code for the given URL and return as a data URL
     *
     * @param string $url The URL to encode in the QR code
     * @return string The data URL containing the QR code image
     */
    public function generateQrCodeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        // A free QR code API
        $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($url);

        try {
            // Create HTTP client
            $httpClient = HttpClient::create();

            // Send request
            $response = $httpClient->request('GET', $apiUrl);

            // Get content type from headers
            $headers = $response->getHeaders();
            $contentType = $headers['content-type'][0] ?? 'image/png';

            // Get image data
            $imageData = $response->getContent();

            // Convert image data to base64
            $base64 = base64_encode($imageData);

            // Return data URL
            return 'data:' . $contentType . ';base64,' . $base64;

        } catch (TransportExceptionInterface | ClientExceptionInterface | 
                 RedirectionExceptionInterface | ServerExceptionInterface $e) {
            // Log error if needed
            // error_log('Error fetching QR code: ' . $e->getMessage());
            return '';
        }
    }
}
