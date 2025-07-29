<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeService implements QrCodeServiceInterface
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

        try {
            $builder = new Builder(
                writer: new SvgWriter(),
                data: $url,
                encoding: new Encoding('UTF-8'),
                errorCorrectionLevel: ErrorCorrectionLevel::Medium,
                size: 200,
                margin: 10,
                roundBlockSizeMode: RoundBlockSizeMode::Margin
            );

            $result = $builder->build();
            $imageData = $result->getString();
            $base64 = base64_encode($imageData);

            return 'data:image/svg+xml;base64,' . $base64;

        } catch (\Exception $e) {
            return '';
        }
    }
}