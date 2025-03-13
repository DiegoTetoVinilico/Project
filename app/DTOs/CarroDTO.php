<?php

namespace App\DTOs;

class CarroDTO
{
    public function __construct(
        public readonly int $id,
        public readonly int $modelo_id,
        public readonly string $placa,
        public readonly bool $disponivel,
        public readonly int $km,
        public readonly string $created_at,
        public readonly string $updated_at
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            modelo_id: $data['modelo_id'],
            placa: $data['placa'],
            disponivel: $data['disponivel'],
            km: $data['km'],
            created_at: $data['created_at'],
            updated_at: $data['updated_at']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'modelo_id' => $this->modelo_id,
            'placa' => $this->placa,
            'disponivel' => $this->disponivel,
            'km' => $this->km,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}