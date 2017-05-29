<?php

/**
 * @file inc/ApiClient.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ApiClient
 * @ingroup includes
 *
 * @brief Wrapper class for guzzle to handle communication with REST API
 */

namespace App;

class ApiClient {

  /** @var string $url */
  protected $url = null;

  /** @var string $journal */
  protected $journal = null;

  /** @var string $version */
  protected $version = null;

  /** @var string $token */
  protected $token = null;

  /** @var string $client */
  protected $client = null;

  /**
  * Constructor
  */
  public function __construct($url, $journal, $version, $token) {
    $this->url = rtrim($url,'/');
    $this->journal = $journal;
    $this->version = $version;
    $this->token = $token;

    $this->client = new \GuzzleHttp\Client([
      'base_uri' => $this->url,
      'timeout'  => 2.0,
    ]);
  }

  /**
  * Handle get requests
  * @param string $endpoint
  * @param array
  *
  * @return array
  */
  public function get($endpoint, $params = array()) {
    if (!isset($params['apiToken'])) {
      $params['apiToken'] = $this->token;
    }

    $url = "{$this->url}/index.php/{$this->journal}/api/{$this->version}/{$endpoint}";
    $response = $this->client->request('GET', $url, array(
      'query' => $params
    ));

    return json_decode($response->getBody()->getContents(), true);
  }
}
