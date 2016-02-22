<?php

require '.env.php';
require 'dbc.php';

echo "are you sure you want to run a migration?(yes)\n> ";

if (trim(fgets(STDIN)) !== 'yes'){
    die();
}

$createTableQuery = 'CREATE TABLE decks(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cards TEXT NOT NULL,
    PRIMARY KEY (id)
)';

$dbc->exec('DROP TABLE IF EXISTS decks');
$dbc->exec($createTableQuery);

echo "migration completed!" . PHP_EOL;
