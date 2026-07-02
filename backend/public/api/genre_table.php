<?php

$pdo = new PDO(
    "mysql:host=mariadb;dbname=filmdb;charset=utf8",
    "filmdb",
    "secret"
);

$pdo->setAttribute(pdo::MYSQL_ATTR_USE_BUFFERED_QUERY, false);


$statement = $pdo->prepare('INSERT INTO genres (genrename) VALUES (:genrename)');

$status = $statement->execute([
    'genrename' => 'Drama',
]);

echo ($status);

?>