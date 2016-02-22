<?php

require '.env.php';
require 'dbc.php';

$createTableQuery = 'CREATE TABLE decks(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cards TEXT NOT NULL,
    PRIMARY KEY (id)
)';

$dbc->exec('DROP TABLE IF EXISTS cards');
$dbc->exec($createTableQuery);
