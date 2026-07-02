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

    public function getById(int $id): array
    {
        $sql = "SELECT *
            FROM filme
            WHERE FilmeId = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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
        )";

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

    public function update(int $id, array $movie)
    {
        $sql = "UPDATE filme SET Titel=?, Altersfreigabe=?, Erscheinungsjahr=?, Genre1=?, Genre2=?, Genre3=?, Filmlaenge=?, File=? WHERE FilmeId=?";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(1, $movie['titel'], PDO::PARAM_STR);
        $stmt->bindParam(2, $movie['altersfreigabe'], PDO::PARAM_INT);
        $stmt->bindParam(3, $movie['erscheinungsjahr'], PDO::PARAM_INT);
        $stmt->bindParam(4, $movie['genres'][0], PDO::PARAM_STR);
        $stmt->bindParam(5, $movie['genres'][1], PDO::PARAM_STR);
        $stmt->bindParam(6, $movie['genres'][2], PDO::PARAM_STR);
        $stmt->bindParam(7, $movie['filmlaenge'], PDO::PARAM_INT);
        // $stmt->bindParam(8, $movie['file'], PDO::PARAM_STR);
        $stmt->bindParam(8, $hardcodedImage, PDO::PARAM_STR);
        $stmt->bindParam(9, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM filme WHERE FilmeId=?";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(1, $id, PDO::PARAM_INT);


        return $stmt->execute();
    }
}
