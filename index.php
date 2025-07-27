<?php

require_once __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$qrCodeUrl = '';
$submittedUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['url'])) {
    $submittedUrl = $_POST['url'];
    // A free QR code API
    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode($submittedUrl);
}

echo $twig->render('index.html.twig', [
    'qrCodeUrl' => $qrCodeUrl,
    'submittedUrl' => $submittedUrl,
]);
