<?php 

    namespace App\Repositories;
    use App\Models\Carro;

    class CarroRepository extends AbstractRepository{
    public function __construct(private Carro $carro) {}

    public function findAll(): array
    {
        return $this->carro->all()->toArray();
    }

    public function findById(int $id):Carro|null
    {
        return $this->carro->find($id);
    }

    public function create(array $data): Carro
    {
        return $this->carro->create($data);
    }

    public function update(int $id, array $data): ?Carro
    {
        $carro = $this->carro->find($id);
        if ($carro) {
            $carro->update($data);
        }
        return $carro;
    }

    public function delete(int $id): bool
    {
        return $this->carro->destroy($id) > 0;
    }
    }