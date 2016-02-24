<?php

require '.env.php';
require 'dbc.php';

echo "are you sure you want to run a migration?(yes)\n> ";

if (trim(fgets(STDIN)) !== 'yes'){
    echo "exiting... no migrations run" . PHP_EOL;
    die();
}

$createTableQuery = 'CREATE TABLE decks(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cards TEXT NOT NULL,
    unique_id VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)';

$dbc->exec('DROP TABLE IF EXISTS decks');
$dbc->exec($createTableQuery);

echo "migration completed!" . PHP_EOL;
