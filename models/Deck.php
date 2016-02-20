<?php 

require('Model.php');

class Deck {
    public $cards = []; 

    public function __construct($cards = []){
        if (empty($cards)){
            $suits = ['C', 'S', 'H', 'D'];
            $values = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];

            foreach($suits as $suit){
                foreach($values as $val){
                    $this->cards[] = ['suit' => $suit, 'value' => $val];
                }
            }
        }
    }
}
