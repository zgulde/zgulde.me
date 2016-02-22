<?php 

require_once 'Card.php';

class Deck {
    public $cards = []; 
    public $id    = 0;

    public function __construct($id = null, $cards = []){

        $this->id = $id;

        // create a new full deck if no cards are passed
        if (empty($cards)){
            $suits  = ['C', 'S', 'H', 'D'];
            $values = ['2','3','4','5','6','7','8','9','10','J','Q','K','A'];

            foreach($suits as $suit){
                foreach($values as $val){
                    $this->cards[] = new Card(['suit' => $suit, 'value' => $val]);
                }
            }

        } else {
            foreach ($cards as $card) {
                $this->cards[] = new Card($card);
            }
        }
    }

    public static function find($id){
        // grab the PDO database connection
        require '../dbc.php';

        $query = 'SELECT cards FROM decks WHERE id = :id';
        $stmt = $dbc->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $cards = $stmt->fetch(PDO::FETCH_ASSOC)['cards'];

        if ($cards) {
            $cards = json_decode($cards, true);
            return new self($id, $cards);
        } else {
            throw new Exception("Deck with id $id not found");
        }

    }

    public function shuffle(){
        shuffle($this->cards);
    }

    public function save(){
        require '../dbc.php';

        if ($this->id) {
            // update
            $query = 'UPDATE decks SET cards = :cards WHERE id = :id';
            $stmt = $dbc->prepare($query);
            $stmt->bindValue(':cards', json_encode($this->cards), PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);
            $stmt->execute();

        } else {
            // no id, so this is a new deck 
            $query = 'INSERT INTO decks (cards) VALUES (:cards)';
            $stmt = $dbc->prepare($query);
            $stmt->bindValue(':cards', json_encode($this->cards), PDO::PARAM_STR);
            $stmt->execute();
            $this->id = $dbc->lastInsertId();
        }
    }

}
