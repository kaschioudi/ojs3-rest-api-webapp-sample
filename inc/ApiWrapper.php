<?php

/**
 * @file inc/ApiWrapper.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ApiClient
 * @ingroup includes
 *
 * @brief Helper class that encapsulates communication with REST API
 */

namespace App;

require 'ApiClient.php';

class ApiWrapper {

  /** @var App\ApiClient $apiClient */
  protected $apiClient = null;

  /**
  * Constructor
  */
  public function __construct() {
    $config = require_once 'config.php';
    $this->apiClient = new apiClient(
      $config['url'],
      $config['journal'],
      $config['apiVersion'],
      $config['apiToken']
    );
  }

  /**
  * Fetch issue list
  */
  public function fetchIssueList() {
    return $this->apiClient->get('issues');
  }

  /**
  * Fetch a specific issue metadata
  *
  * @param int $issueID
  */
  public function fetchIssueDetails($issueId) {
    $endpoint = "issues/" . intval($issueId);
    return $this->apiClient->get($endpoint);
  }

  /**
  * Fetch a article
  *
  * @param int $articleId
  */
  public function fetchArticle($articleId) {
    $endpoint = "articles/" . intval($articleId);
    return $this->apiClient->get($endpoint);
  }
}
