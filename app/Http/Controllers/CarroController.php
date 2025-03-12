<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreCarroRequest,UpdateCarroRequest};
use App\Services\CarroService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CarroController extends Controller
{
    public function __construct(private CarroService $service) {}

    public function index(): JsonResponse
    {
        $carros = $this->service->getAll();
        
        return response()->json($carros);
    }

    public function show(int $id): JsonResponse
    {
        $carro = $this->service->getById($id);
        return $carro ? response()->json($carro) : response()->json(['error' => 'Carro não encontrado'], 404);
    }

    public function store(StoreCarroRequest $request): JsonResponse
    {
        $carro = $this->service->create($request->all());
        return response()->json($carro, 201);
    }

    public function update(UpdateCarroRequest $request, int $id): JsonResponse
    {
        $carro = $this->service->update($id, $request->all());
        return $carro ? response()->json($carro) : response()->json(['error' => 'Carro não encontrado'], 404);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->service->delete($id) 
            ? response()->json(['message' => 'Carro excluído com sucesso']) 
            : response()->json(['error' => 'Carro não encontrado'], 404);
    }
}

