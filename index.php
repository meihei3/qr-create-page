<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\QrCodeController;
use App\Services\QrCodeService;
use App\Services\QrCodeServiceInterface;
use App\Services\FaviconService;
use App\Services\FaviconServiceInterface;
use App\Views\ViewManager;
use DI\ContainerBuilder;
use DI\Bridge\Slim\Bridge;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

// Set up DI container
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    // Define HttpClientInterface
    HttpClientInterface::class => function() {
        return HttpClient::create();
    },

    // Define QrCodeService
    QrCodeServiceInterface::class => function() {
        return new QrCodeService();
    },

    // Define FaviconService
    FaviconServiceInterface::class => function() {
        return new FaviconService();
    },

    // Define QrCodeController
    QrCodeController::class => function(QrCodeServiceInterface $qrCodeService, FaviconServiceInterface $faviconService) {
        return new QrCodeController($qrCodeService, $faviconService);
    }
]);

// Build container
$container = $containerBuilder->build();

// Create Slim app using the container
$app = Bridge::create($container);

// Set up Views
ViewManager::setup($app);

// Define routes
$app->get('/', [QrCodeController::class, 'index']);
$app->get('/generate', [QrCodeController::class, 'generate']);
$app->get('/favicon.ico', [QrCodeController::class, 'favicon']);

// Run the app
$app->run();
