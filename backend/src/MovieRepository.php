<?php

class MovieRepository
{
    public function __construct(
        private PDO $db
    ) {}

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM filme
            ORDER BY Titel ASC
        ");

        return $stmt->fetchAll();
    }
}