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

    return json_decode($response->getBody());
  }

  public function approvalAtasan($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-atasan", [
      'json' => $data
    ]);

    return json_decode($response->getBody());
  }

  public function approvalHRD($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-hrd", [
      'json' => $data
    ]);

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

    return json_decode($response->getBody());
  }

  public function approvalPengesah($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/approval-pengesah", [
      'json' => $data
    ]);

    return json_decode($response->getBody());
  }

  public function needRevision($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/need-revision", [
      'json' => $data
    ]);

    return json_decode($response->getBody());
  }

  public function updateSubmission($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/update-submission", [
      'json' => $data
    ]);

    return json_decode($response->getBody());
  }

  public function reject($id, $data)
  {
    $response = $this->client->put($this->baseUrl . "/submissions/$id/reject", [
      'json' => $data
    ]);

    return json_decode($response->getBody());
  }

  public function getSubmissionById($id){
    $response = $this->client->get($this->baseUrl . "/submissions/$id");

    return json_decode($response->getBody());
  }

  public function showByUser($id){
    $response = $this->client->get($this->baseUrl . "/submissions/users/$id");

    return json_decode($response->getBody());
  }

  public function showItems($id){
    $response = $this->client->get($this->baseUrl . "/submissions/$id/items");

    return json_decode($response->getBody());
  }
}
