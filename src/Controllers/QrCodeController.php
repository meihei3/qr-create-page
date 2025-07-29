<?php

namespace App\Controllers;

use App\Services\QrCodeServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class QrCodeController
{

    public function __construct(
        private readonly QrCodeServiceInterface $qrCodeService
    ) {
    }

    /**
     * Display the QR code generation form
     */
    public function index(Request $request, Response $response): Response
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html.twig', [
            'qrCodeUrl' => '',
            'submittedUrl' => '',
        ]);
    }

    /**
     * Generate QR code from URL query parameter
     */
    public function generate(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();

        $submittedUrl = $queryParams['url'] ?? '';
        $qrCodeUrl = $this->qrCodeService->generateQrCodeUrl($submittedUrl);

        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html.twig', [
            'qrCodeUrl' => $qrCodeUrl,
            'submittedUrl' => $submittedUrl,
        ]);
    }

    /**
     * Return favicon as QR code for "favicon.ico" text
     */
    public function favicon(Request $request, Response $response): Response
    {
        $qrCodeDataUrl = $this->qrCodeService->generateQrCodeUrl('favicon.ico');
        
        // Extract base64 data from data URL
        $base64Data = substr($qrCodeDataUrl, strpos($qrCodeDataUrl, ',') + 1);
        $svgContent = base64_decode($base64Data);
        
        $response->getBody()->write($svgContent);
        return $response->withHeader('Content-Type', 'image/svg+xml');
    }
}
