<?php

namespace App\Services;

use App\DTOs\CarroDTO;
use App\Repositories\CarroRepository;

class CarroService
{
    public function __construct(private CarroRepository $repository) {}

    public function getAll(): array
    {
        return array_map(fn($carro) => CarroDTO::fromArray($carro), $this->repository->findAll());
    }

    public function getById(int $id): ?CarroDTO
    {
        $carro = $this->repository->findById($id);
        return $carro ? CarroDTO::fromArray($carro->toArray()) : null;
    }

    public function create(array $data): CarroDTO
    {
        $carro = $this->repository->create($data);
        return CarroDTO::fromArray($carro->toArray());
    }

    public function update(int $id, array $data): ?CarroDTO
    {
        $carro = $this->repository->update($id, $data);
        return $carro ? CarroDTO::fromArray($carro->toArray()) : null;
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}