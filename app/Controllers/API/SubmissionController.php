<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class SubmissionController extends BaseController
{
    use ResponseTrait;
    public function storeSubmission()
    {
        $data = $this->request->getJSON();
        $submissionService = \Config\Services::submissionServiceApi();
        $response = $submissionService->storeSubmission($data);

        // log_message('debug', 'SubmissionController::storeSubmission() response: ' . json_encode($response));
        if (!$response->status === 200) {
            return $this->fail($response, $response->status);
        }

        return $this->respondCreated($response);
    }
}
