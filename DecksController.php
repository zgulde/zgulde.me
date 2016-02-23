<?php

class DecksController {
    public static function create($req, $res, $args){
        $res    = $res->withHeader('Content-Type', 'application/json; charset=UTF-8');
        $params = $req->getParsedBody();

        $deck = new Deck();

        if (isset($params['shuffle']) && $params['shuffle'] == 'true'){
            $deck->shuffle();
        }

        $deck->save();
        $res->write(json_encode($deck));

        return $res;
    }

    public static function get($req, $res, $args){
        $res = $res->withHeader('Content-Type', 'application/json; charset=UTF-8');

        try {
            $deck = Deck::find($args['id']);
        } catch (Exception $e) {
            $res->write(json_encode(['error' => $e->getMessage()]));
        }

        switch ($args['action']){
            case 'show':

                break;
            case 'shuffle':

                break;
            case 'draw':

                break;
        }

        $res->write(json_encode($deck));

        return $res;
    }
}
