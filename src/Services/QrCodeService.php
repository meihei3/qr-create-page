<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class QrCodeService implements QrCodeServiceInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
    ) {
    }

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

        $apiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($url);

        try {
            $response = $this->httpClient->request('GET', $apiUrl);

            $headers = $response->getHeaders();
            $contentType = $headers['content-type'][0] ?? 'image/png';

            $imageData = $response->getContent();

            $base64 = base64_encode($imageData);

            return 'data:' . $contentType . ';base64,' . $base64;

        } catch (TransportExceptionInterface | ClientExceptionInterface | 
                 RedirectionExceptionInterface | ServerExceptionInterface $e) {
            return '';
        }
    }
}