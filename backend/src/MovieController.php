<?php

class MovieController
{
    public function __construct(
        private MovieRepository $repository
    ) {}

    public function getAll(): void
    {
        $movies = $this->repository->getAll();

        http_response_code(200);

        echo json_encode($movies);
    }

    public function getById(int $id): void
    {
        $movie = $this->repository->getById($id);

        if ($movie === false) {
            http_response_code(404);

            echo json_encode([
                "message" => "Movie not found."
            ]);

            return;
        }

        http_response_code(200);
        echo json_encode($movie);
    }

    public function create(): void
    {
        $data = file_get_contents('php://input');
        $parsed = json_decode($data, true);

        // TODO: Validierung

        $success = $this->repository->create($parsed);

        if ($success) {
            http_response_code(201);

            echo json_encode([
                "message" => "Movie created successfully."
            ]);
        } else {
            http_response_code(500);

            echo json_encode([
                "message" => "Movie could not be created."
            ]);
        }
    }

    public function update(): void
    {
        $data = file_get_contents('php://input');
        $parsed = json_decode($data, true);

        // TODO: Validierung

        $success = $this->repository->update($parsed['id'], $parsed);

        if ($success) {
            http_response_code(200);

            echo json_encode([
                "message" => "Movie updated successfully."
            ]);
        } else {
            http_response_code(204);

            echo json_encode([
                "message" => "Movie could not be updated."
            ]);
        }
    }

    public function delete(): void
    {
        $data = file_get_contents('php://input');
        $parsed = json_decode($data, true);

        $success = $this->repository->delete($parsed['id']);

        if ($success) {
            http_response_code(200);

            echo json_encode([
                "message" => "Movie deleted successfully."
            ]);
        } else {
            http_response_code(204);

            echo json_encode([
                "message" => "Movie could not be deleted."
            ]);
        }
    }
}
