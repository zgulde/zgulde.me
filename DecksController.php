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
            $res->write(json_encode([
                'success' => false,
                'error'   => $e->getMessage()
            ]));
            return $res;
        }

        $params = $req->getParsedBody();

        switch ($args['action']){
            case 'show':
                $res->write(json_encode($deck));
                break;
            case 'shuffle':
                $deck->shuffle();
                $deck->save();
                $res->write(json_encode([
                    'success'         => true,
                    'cards_remaining' => $deck->cards_remaining
                ]));
                break;
            case 'draw':
                try{
                    $count = isset($params['count']) ? $params['count'] : 1;
                    $cards = $deck->draw($count);
                    $deck->save();
                    $res->write(json_encode([

                        'success' => true,
                        'cards' => $cards,
                        'cards_remaining' => $deck->cards_remaining
                    ]));

                } catch (Exception $e) {
                    $res->write(json_encode([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]));
                }

                break;
            default:
                $res->write(json_encode([
                    'success' => false,
                    'error'   => 'invalid action'
                ]));
                break;
        }


        return $res;
    }
}
