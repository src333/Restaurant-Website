<?php

//require_once 'vendor/autoload.php'; // Autoload Composer dependencies
require_once ('/var/www/html/courseworkWD/vendor/autoload.php');

// Specify the directory for Twig templates
$loader = new \Twig\Loader\FilesystemLoader('/var/www/html/courseworkWD/courseworkWD/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => '/var/www/html/courseworkWD/courseworkWD/cache', // Enable caching for performance (optional during development)
    'debug' => true,               // Enable debugging
]);

// Return the Twig environment to use in other scripts
return $twig;
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php');
