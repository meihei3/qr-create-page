<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;

class QrCodeService implements QrCodeServiceInterface
{
    private const int QR_CODE_SIZE = 200;
    private const int QR_CODE_MARGIN = 10;

    public function generateQrCodeUrl(string $url): string
    {
        if (empty($url)) {
            return '';
        }

        try {
            $result = $this->buildQrCode($url);
            return $this->convertToDataUrl($result->getString());

        } catch (\Exception $e) {
            error_log("QR Code generation error: " . $e->getMessage());
            return '';
        }
    }

    private function buildQrCode(string $data): ResultInterface
    {
        $builder = new Builder(
            writer: new PngWriter(),
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: self::QR_CODE_SIZE,
            margin: self::QR_CODE_MARGIN,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        return $builder->build();
    }

    private function convertToDataUrl(string $imageData): string
    {
        $base64 = base64_encode($imageData);
        return 'data:image/png;base64,' . $base64;
    }
}