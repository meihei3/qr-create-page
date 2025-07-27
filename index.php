<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Controllers\QrCodeController;
use App\Views\ViewManager;
use Slim\Factory\AppFactory;

// Create Slim app
$app = AppFactory::create();

// Set up Views
ViewManager::setup($app);

// Create controller instance
$qrCodeController = new QrCodeController();

// Define routes
$app->get('/', [$qrCodeController, 'index']);
$app->post('/', [$qrCodeController, 'generate']);

// Run the app
$app->run();
