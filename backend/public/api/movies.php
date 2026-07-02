<?php

require_once "../../src/Database.php";
require_once "../../src/MovieRepository.php";
require_once "../../src/MovieController.php";

header("Content-Type: application/json");

$db = new Database();

$repository = new MovieRepository(
    $db->getConnection()
);

$controller = new MovieController($repository);

$controller->getAll();