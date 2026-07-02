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

    public function create(): void
    {
        $data = json_decode(
            file_get_contents("php://input"),
            true
        );

        // TODO: Validierung

        $success = $this->repository->create($data);

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
}
