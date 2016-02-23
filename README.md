# zgulde.me

This is a repository for my personal site with a backend.

Right now it will just redirect to zgulde.com where I host my main site.

Check back soon for updates!

# Deck of Cards api

Inspired by [this hacker news article](https://news.ycombinator.com/item?id=9522489).

Visit [the original creator](http://deckofcardsapi.com/).

I wanted to rebuild a deck of cards api using the tools I know. This site is built with the [Slim PHP micro framework](http://www.slimframework.com/).

## Overview

Each deck is represented as a javascript object with several properties:

- `id` the id of the deck, used to access the deck
- `cards_remaining` the remaining number of cards in the deck
- `cards` an array of card objects

Each card object has several properties:

- `suit`
    - `C` clubs
    - `H` hearts
    - `D` diamonds
    - `S` spades
- `value`
    - `2` through `10`
    - `J`, `Q`, `K`, `A` jack, queen, king, and ace, respectively
- `string`
    - a string representing the card e.g. `KH`, `10D`

**Example Response**

```json
// GET /decks/{deck_id}

{
    "id": "42",
    "cards_remaining": 2,
    "cards": [
        {
            "suit": "S",
            "value": "2",
            "string": "2S"
        },
        {
            "suit": "H",
            "value": "2",
            "string": "2H"
        },
        {
            "suit": "D",
            "value": "3",
            "string": "3D"
        }
    ]
}
```



## Routes

All routes are based of of `zgulde.me/cardsapi/`

### Creating a new Deck

`POST` to `/decks`

- optionally include a parameter `shuffle` set to `true` to return a shuffled deck

**jQuery ajax request Example**

```js
$.post('zgulde.me/cardsapi/decks', {
    "shuffle": true    
})
```
