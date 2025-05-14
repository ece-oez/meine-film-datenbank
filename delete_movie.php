<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(403);
    exit();
}

// Hole übergebene Daten und parse sie

$data = file_get_contents('php://input');  // Json string (obj = daten)
$parsed = json_decode($data, true);

// DB-Verbindung

$pdo = new PDO("mysql:host=localhost;dbname=mfdb", 'eceoezmen', 'eceece');

$sql = "DELETE FROM filme WHERE FilmeId=?";

$statement = $pdo->prepare($sql);

$statement->bindParam(1, $parsed['id'], PDO::PARAM_INT);

$statement->execute();


if($statement){
    $data = [
        'errormessage' => "Film wurde erfolgreich geloescht!"
    ];
}else{
    $data = [
        'errormessage' => "Unbekannter Fehler beim Loeschen aufgetreten!"
    ];
}


echo json_encode($data);


// SQL Ausführen, Über Zeilen iterieren und ggf. filtern und Daten in ein Array speichern

// Array zu einem json string machen und zu javascript antworten

$pdo = null;
?>