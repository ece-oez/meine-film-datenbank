<?php

require_once "../../src/Database.php";
require_once "../../src/MovieRepository.php";

header("Content-Type: application/json");

try {

    $database = new Database();

    $repository = new MovieRepository(
        $database->getConnection()
    );

    echo json_encode(
        $repository->getAll()
    );

} catch(Exception $e) {

    http_response_code(500);

    echo json_encode([
        "error" => $e->getMessage()
    ]);

}