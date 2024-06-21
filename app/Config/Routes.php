<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('check-db', function(){
    try {
        $db = \Config\Database::connect();
        $db->initialize();
        echo 'Database connection is OK';
    } catch (\Exception $e) {
        echo 'Database connection failed: ' . $e->getMessage();
    }
});
