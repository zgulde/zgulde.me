<?php

require_once '../bootstrap.php';

function dd($var){
    var_dump($var);
    die();
}

set_error_handler(function($no, $msg){
    var_dump($msg);
    die();
});

$app = new Slim\App();

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

$app->post('/cardsapi/decks', function($req, $res, $args){
    $res    = $res->withHeader('Content-Type', 'application/json; charset=UTF-8');
    $params = $req->getParsedBody();

    $deck = new Deck();

    if (isset($params['shuffle']) && $params['shuffle'] == 'true'){
        $deck->shuffle();
    }

    $deck->save();
    $res->write(json_encode($deck));

    return $res;
});

$app->get('/cardsapi/decks/{id}', function($req, $res, $args){
    $res = $res->withHeader('Content-Type', 'application/json; charset=UTF-8');

    try {
        $deck = Deck::find($args['id']);
        $res->write(json_encode($deck));
    } catch (Exception $e) {
        $res->write(json_encode(['error' => $e->getMessage()]));
    }

    return $res;
});

$app->put('/cardsapi/decks/{id}', function($req, $res, $args){
    $res = $res->withHeader('Content-Type', 'application/json; charset=UTF-8');

    try {
        $deck = Deck::find($args['id']);
    } catch (Exception $e) {
        $res->write(json_encode([
            'success' => false,
            'error'   => $e->getMessage()
        ]));
    }

    $params = $req->getParsedBody();

    switch ($params['action']){
        case 'shuffle':
            $deck->shuffle();
            $deck->save();
            $res->write(json_encode([
                'success'         => true,
                'cards_remaining' => $deck->cards_remaining
            ]));
            break;

        case 'draw':
            $count = isset($params['count']) ? $params['count'] : 1;
            try {
                $res->write(json_encode([
                    'success'         => true,
                    'cards'           => $deck->draw($count),
                    'cards_remaining' => $deck->cards_remaining
                ]));
            } catch (Exception $e) {
                $res->write(json_encode([
                    'success' => false,
                    'error'   => $e->getMessage()
                ]));
            }
            $deck->save();
            break;

        default: 
            $res->write(json_encode([
                'success' => false,
                'error'   => 'invalid action!'
            ]));
            break;

    }
    return $res;
});

$app->run();
