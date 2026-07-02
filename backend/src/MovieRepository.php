<?php

class MovieRepository
{
    public function __construct(
        private PDO $db
    ) {}

    public function getAll(): array
    {

        $sql = "SELECT *
            FROM filme
            ORDER BY Titel ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }


    public function getById(int $id) {}

    public function create(array $movie): bool
    {
        $sql = "
        INSERT INTO filme
        (
            Titel,
            Altersfreigabe,
            Erscheinungsjahr,
            Genre1,
            Genre2,
            Genre3,
            Filmlaenge,
            File
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            $movie["titel"],
            $movie["altersfreigabe"],
            $movie["erscheinungsjahr"],
            $movie["genres"][0] ?? null,
            $movie["genres"][1] ?? null,
            $movie["genres"][2] ?? null,
            $movie["filmlaenge"],
            $movie["file"] ?? "default.jpg"
        ]);
    }

    public function update(int $id, array $movie) {}

    public function delete(int $id) {}
}
