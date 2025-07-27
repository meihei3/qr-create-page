<?php

namespace App\Controllers;

use App\Models\QrCodeModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class QrCodeController
{
    /**
     * @var QrCodeModel
     */
    private $qrCodeModel;

    /**
     * QrCodeController constructor.
     */
    public function __construct()
    {
        $this->qrCodeModel = new QrCodeModel();
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
     * Generate QR code from submitted URL
     */
    public function generate(Request $request, Response $response): Response
    {
        $params = (array)$request->getParsedBody();

        $submittedUrl = $params['url'] ?? '';
        $qrCodeUrl = $this->qrCodeModel->generateQrCodeUrl($submittedUrl);

        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html.twig', [
            'qrCodeUrl' => $qrCodeUrl,
            'submittedUrl' => $submittedUrl,
        ]);
    }
}
