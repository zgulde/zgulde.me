<?php

require '../vendor/autoload.php';

function dd($var){
    var_dump($var);
    die();
}

$app = new Slim\App();

// landing page
$app->get('/', function($req, $res, $args){
    $res = $res->withHeader('Location', 'http://zgulde.com');
    return $res;
});

$app->get('/cardsapi', function($req, $res, $args){
    $res->write(file_get_contents('../views/cardsapi.html'));
    return $res;    
});

$app->run();
