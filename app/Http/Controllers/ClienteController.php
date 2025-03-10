<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Repositories\ClienteRepository;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use \Symfony\Component\HttpFoundation\Response;

class ClienteController extends Controller
{   
    protected $cliente;
    public function __construct(Cliente $cliente){
        $this->cliente = $cliente;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clienteRepository = new ClienteRepository($this->cliente);
        
        if($request->has("filtro")){
            $clienteRepository->filtro($request->filtro);
        }
        if($request->has("atributos")){
            $clienteRepository->selectAtributos($request->atributos);
        }
        return response($clienteRepository->getResultado(),Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $validated = $request->validated();
        #Stateless
        /*No caso de não passar na validação, ocorre o Stateless (Sem estado).
        Não mantém informações sobre o estado de uma conexão ou sessão.
        Por padrão, o usuário será redirecionado para a rota padrão
        */

        $cliente = $this->cliente->create($validated);

        return response($cliente,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = $this->cliente->findOrFail($id);

        return response($cliente,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, $id)
    {
        $cliente = $this->cliente->findOrFail($id);

        //Valida os dados da requisição
        $validated = $request->validated();
     
        $cliente->fill($validated);
        $cliente->save();
    
        return response($cliente,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->findOrFail($id);

        $cliente->delete();
        return response($cliente,Response::HTTP_OK); 
    }
}
