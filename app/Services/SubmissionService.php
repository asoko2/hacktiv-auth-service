<?php

namespace App\Services;

class SubmissionService
{
  protected $client;
  protected $baseUrl;

  public function __construct()
  {
    $this->client = \Config\Services::curlrequest([
      'http_errors' => false,
    ]);
    $this->baseUrl = env("URL_SUBMISSION_SERVICE");
  }

  public function storeSubmission($data)
  {
    $response = $this->client->post($this->baseUrl . '/submissions', [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::storeSubmission() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }
}
