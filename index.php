<?php

/**
 * @file index.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @brief Web app entry point
 */

require 'vendor/autoload.php';
require 'inc/ApiWrapper.php';

$config = [
  'settings' => [
      'displayErrorDetails' => true,
  ]
];
$app = new Slim\App($config);

$container = $app->getContainer();
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('./views/templates', [
        'cache' => false,//'./views/templates'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};

$apiWrapper = new App\ApiWrapper();

// issue list
$app->get('/', function ($request, $response, $args) use ($apiWrapper) {
  $issues = $apiWrapper->fetchIssueList();
  return $this->view->render($response, 'issues.html', [
    'issues' => $issues
  ]);
});

// view issue
$app->get('/issue/view/{issueId}', function ($request, $response, $args) use ($apiWrapper) {
  $issue = $apiWrapper->fetchIssueDetails($args['issueId']);
  // var_dump($issue);
  return $this->view->render($response, 'issue.html', [
    'issue' => $issue
  ]);
});

// view article
$app->get('/article/view/{articleId}', function ($request, $response, $args) use ($apiWrapper) {
  $article = $apiWrapper->fetchArticle($args['articleId']);
  // var_dump($article);
  return $this->view->render($response, 'article.html', [
    'article' => $article
  ]);
});

$app->run();
