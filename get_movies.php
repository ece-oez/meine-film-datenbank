<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(403);
    exit();
}

// Hole übergebene Daten und parse sie

// $data = file_get_contents('php://input');  // Json string (obj = daten)
// $parsed = json_decode($data, true);

// DB-Verbindung

$pdo = new PDO("mysql:host=localhost;dbname=mfdb", 'eceoezmen', 'eceece');

// SQL-Statement zusammenbauen mit parameter bindung und sanatization

// Filme Suchen Array füllen

$statement = $pdo->prepare('SELECT * FROM filme');

$status = $statement->execute();

$arr = [];

while($row = $statement->fetch()){
    array_push($arr,$row);
}

// Auto increment neu setzen

$arrLength = count($arr);

$sql = "UPDATE filme SET FilmeId=:filmId WHERE Titel=:titel";

$statement = $pdo->prepare($sql);

$i = 0;

    foreach($arr as $value){
        $i++;
        $statement->bindParam(':filmId', $i, PDO::PARAM_INT);
        $statement->bindParam(':titel', $value[1], PDO::PARAM_STR);
        $statement->execute();
    }
unset($value);

$increment = $pdo->lastInsertId();

$sql = "ALTER TABLE filme AUTO_INCREMENT=:incrementId";

$statement = $pdo->prepare($sql);

$statement->bindParam(':incrementId', $increment, PDO::PARAM_INT);

$statement->execute();

echo json_encode($arr);

// Array zu einem json string machen und zu javascript antworten

$pdo = null;
?>