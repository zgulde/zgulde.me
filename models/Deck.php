<?php 

require_once 'Card.php';

class Deck {
    public $cards = []; 
    public $id    = 0;

    public function __construct($id = null, $cards = []){

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

        // check if id is null if so, this is a new Deck, insert it into db 
        // and save it, otherwise just return a deck object with given id
        if ($id){
            $this->id = $id;
        } else {
            require_once '../dbc.php';
            $query = 'INSERT INTO decks (cards) VALUES (:cards)';
            $stmt = $dbc->prepare($query);
            $stmt->bindValue(':cards', json_encode($this->cards), PDO::PARAM_STR);
            $stmt->execute();
            $this->id = $dbc->lastInsertId();
        }

    }

    public static function find($id){
        // grab the PDO database connection
        require_once '../dbc.php';

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

}
