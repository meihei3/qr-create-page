<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\QrCodeController;
use App\Services\QrCodeService;
use App\Services\QrCodeServiceInterface;
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

    // Define QrCodeController
    QrCodeController::class => function(QrCodeServiceInterface $qrCodeService) {
        return new QrCodeController($qrCodeService);
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
$app->post('/', [QrCodeController::class, 'generate']);

// Run the app
$app->run();
