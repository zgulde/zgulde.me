<?php 

require_once 'Card.php';

class Deck {
    public $cards = []; 
    public $id    = 0;

    public function __construct($cards = []){

        if (empty($cards)){
            $suits  = ['C', 'S', 'H', 'D'];
            $values = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];

            foreach($suits as $suit){
                foreach($values as $val){
                    $this->cards[] = new Card(['suit' => $suit, 'value' => $val]);
                }
            }
        } else {
            $this->cards = $cards;
        }



    }
}
