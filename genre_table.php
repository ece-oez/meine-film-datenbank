<?php

$pdo = new PDO("mysql:host=localhost;dbname=mfdb", 'eceoezmen', 'eceece');

$pdo->setAttribute(pdo::MYSQL_ATTR_USE_BUFFERED_QUERY, false);


$statement = $pdo->prepare('INSERT INTO genres (genrename) VALUES (:genrename)');

$status = $statement->execute([
    'genrename' => 'Drama',
]);

echo ($status);

?>