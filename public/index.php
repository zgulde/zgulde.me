<?php

require_once '../bootstrap.php';

function dd($var){
    var_dump($var);
    die();
}

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);

$app = new Slim\App($c);

// landing page
$app->get('/', function($req, $res, $args){
    $res = $res->withHeader('Location', 'http://zgulde.com');
    return $res;
});

// documentation for api
$app->get('/cardsapi', function($req, $res, $args){
    $res->write(file_get_contents('../views/cardsapi.html'));
    return $res;    
});

/**
 * ----------------------- RESTful routes -----------------------
 */

$app->post('/cardsapi/decks', 'DecksController::create');

$app->get('/cardsapi/decks/{id}[/{action}]', 'DecksController::get')->setArgument('action', 'show');

$app->run();
