<?php

use App\Controllers\API\SubmissionController;
use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('login', [AuthController::class, 'login']);

$routes->group('api', ['filter' => ['jwt', 'blacklistedToken']], function ($routes) {

  $routes->group('submissions',  function ($routes) {

    $routes->post('', [SubmissionController::class, 'storeSubmission']);

    $routes->put('(:segment)/approval-atasan', [SubmissionController::class, 'approvalAtasan/$1']);
    $routes->put('(:segment)/approval-hrd', [SubmissionController::class, 'approvalHRD/$1']);
    $routes->put('(:segment)/approval-pengesah', [SubmissionController::class, 'approvalPengesah/$1']);

    $routes->put('(:segment)/need-revision', [SubmissionController::class, 'needRevision/$1']);
    $routes->put('(:segment)/update-submission', [SubmissionController::class, 'updateSubmission/$1']);

    $routes->put('(:segment)/reject', [SubmissionController::class, 'reject/$1']);

    $routes->post('(:segment)/upload-invoice', [SubmissionController::class, 'uploadInvoice/$1']);
  });
});
