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

  public function approvalAtasan($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-atasan", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::approveAtasan() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function approvalHRD($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-hrd", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::approveHRD() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function uploadInvoice($id, $data)
  {
    $response = $this->client->post($this->baseUrl . "/submissions/$id/upload-invoice", [
      'headers' => [
        'Content-Type' => 'multipart/form-data',
      ],
      'multipart' => $data
    ]);

    log_message('debug', 'SubmissionService::uploadInvoice() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function approvalPengesah($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-pengesah", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::approvePengesah() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function needRevision($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/need-revision", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::needRevision() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function updateSubmission($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/update-submission", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::updateSubmission() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }

  public function reject($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/reject", [
      'json' => $data
    ]);

    log_message('debug', 'SubmissionService::reject() response: ' . json_encode($response));

    return json_decode($response->getBody());
  }
}
