<?php

$pdo = new PDO("mysql:host=localhost;dbname=mfdb", 'eceoezmen', 'eceece');

$pdo->setAttribute(pdo::MYSQL_ATTR_USE_BUFFERED_QUERY, false);


$statement = $pdo->prepare('SELECT * FROM genres');

$status = $statement->execute();

// $rows = $statement->fetch();  <- $rows sind immer = true (holt sich den ersten und das wars)

while($row = $statement->fetch()){  // holt immer nächsten eintrag bis keine mehr da sind
    echo($row['Genrename'] . '<br>' );
}

?>