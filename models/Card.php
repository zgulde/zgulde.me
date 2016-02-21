<?php

class Card {
    public $suit  = '';
    public $value = '';

    public function __construct($card){
        $this->suit   = $card['suit'];
        $this->value  = $card['value'];
        $this->string = $this->value . $this->suit;
    }
}
