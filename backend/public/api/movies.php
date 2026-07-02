<?php

header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once "../../src/Database.php";
require_once "../../src/MovieRepository.php";
require_once "../../src/MovieController.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

$db = new Database();

$repository = new MovieRepository(
    $db->getConnection()
);

$controller = new MovieController($repository);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["id"])) {
            $controller->getById((int) $_GET["id"]);
        } else {
            $controller->getAll();
        }
        break;

    case "POST":
        $controller->create();
        break;

    case "PUT":
        $controller->update();
        break;

    case "DELETE":
        $controller->delete();
        break;

    default:
        http_response_code(405);
        echo json_encode([
            "message" => "Method not allowed."
        ]);
}
