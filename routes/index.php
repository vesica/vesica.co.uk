<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Meezaan\MicroServiceHelper\Response as ApiResponse;

$app->get('/', function (Request $request, Response $response) {
    $this->helper->logger->info('/');

    $res = $this->cache->withExpires($response, time() + (86400 * 7));

    return $this->view->render($res, 'index.phtml', [
        'title' =>'Vesica'
    ]);
});

$app->get('/about', function (Request $request, Response $response) {
    $this->helper->logger->info('/about');

    $res = $this->cache->withExpires($response, time() + (86400 * 7));

    return $this->view->render($res, 'about.phtml', [
        'title' =>'About'
    ]);
});


