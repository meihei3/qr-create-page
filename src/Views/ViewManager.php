<?php

namespace App\Views;

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Loader\FilesystemLoader;

class ViewManager
{
    /**
     * Set up Twig views for the application
     *
     * @param App $app The Slim application instance
     * @return Twig The configured Twig instance
     */
    public static function setup(App $app): Twig
    {
        // Set up Twig with the templates directory
        $twig = Twig::create(__DIR__ . '/templates');

        // Add Twig-View Middleware
        $app->add(TwigMiddleware::create($app, $twig));

        return $twig;
    }
}
