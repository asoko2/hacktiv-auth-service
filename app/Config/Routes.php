<?php

use App\Controllers\API\SubmissionController;
use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('login', [AuthController::class, 'login']);

$routes->group('api', function ($routes) {

  $routes->group('submissions', function ($routes) {

    $routes->post('', [SubmissionController::class, 'storeSubmission']);
  });
});
