<?php

try {
    $pdo = new PDO(
        "mysql:host=mariadb;dbname=filmdb;charset=utf8mb4",
        "filmdb",
        "secret"
    );

    echo "✅ Verbindung erfolgreich!";

} catch (PDOException $e) {
    echo "❌ Fehler: " . $e->getMessage();
}