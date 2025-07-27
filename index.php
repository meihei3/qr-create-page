<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\QrCodeController;
use App\Models\QrCodeModel;
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

    // Define QrCodeModel
    QrCodeModel::class => function(HttpClientInterface $httpClient) {
        return new QrCodeModel($httpClient);
    },

    // Define QrCodeController
    QrCodeController::class => function(QrCodeModel $qrCodeModel) {
        return new QrCodeController($qrCodeModel);
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
