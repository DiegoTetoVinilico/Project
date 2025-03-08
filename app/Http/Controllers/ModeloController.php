<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{   
    protected $modelo;
    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modelo = $this->modelo->all();
        return response($modelo,Response::HTTP_OK);
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
    public function store(StoreModeloRequest $request)
    {
        $validated = $request->validated();
        #Stateless
        /*No caso de não passar na validação, ocorre o Stateless (Sem estado).
        Não mantém informações sobre o estado de uma conexão ou sessão.
        Por padrão, o usuário será redirecionado para a rota padrão
        */
        $imagem_urn = $request->file('imagem')->store('imagens/modelos', 'public');
        $validated['imagem'] = $imagem_urn;
        $modelo = $this->modelo->create($validated);

        return response($modelo,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $modelo = $this->modelo->findOrFail($id);

        return response($modelo,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModeloRequest $request, $id)
    {   
        // Encontra a marca pelo ID ou retorna erro 404
        $modelo = $this->modelo->findOrFail($id);
        //dd($request->nome);
        //dd($request->file('imagem'));

        //Valida os dados da requisição
        $validated = $request->validated();
     
    // Verifica se uma nova imagem foi enviada
    if ($request->file('imagem')) {
        // Armazena a nova imagem no disco 'public' e obtém o caminho
        Storage::disk('public')->delete($modelo->imagem);
        $imagem = $request->file('imagem');
        $imagem_urn= $imagem->store('imagens/modelos', 'public');
        $validated['imagem'] = $imagem_urn;
    }

        // Atualiza a marca no banco de dados
        $modelo->update($validated);
    
        return response($modelo,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->findOrFail($id);
        
        //remove o arquivo antigo
        Storage::disk('public')->delete($modelo->imagem);
        $modelo->delete();
        return response($modelo,Response::HTTP_OK);
    }
}
