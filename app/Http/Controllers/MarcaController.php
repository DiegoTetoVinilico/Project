<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{   
    protected $marca;

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marcas = $this->marca->all();
        return response($marcas,Response::HTTP_OK);
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
    public function store(StoreMarcaRequest $request)
    {

        $validated = $request->validated();
        #Stateless
        /*No caso de não passar na validação, ocorre o Stateless (Sem estado).
        Não mantém informações sobre o estado de uma conexão ou sessão.
        Por padrão, o usuário será redirecionado para a rota padrão
        */
        $imagem_urn = $request->file('imagem')->store('imagens', 'public');
        $validated['imagem'] = $imagem_urn;
        $marca = $this->marca->create([
                                        'nome' => $validated['nome'],
                                        'imagem' => $validated['imagem']
                                        ]);

        return response($marca,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->findOrFail($id);

        return response($marca,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, $id)
    {   
        // Encontra a marca pelo ID ou retorna erro 404
        $marca = $this->marca->findOrFail($id);
        //dd($request->nome);
        //dd($request->file('imagem'));

        //Valida os dados da requisição
        $validated = $request->validated();
     
    // Verifica se uma nova imagem foi enviada
    if ($request->file('imagem')) {
        // Armazena a nova imagem no disco 'public' e obtém o caminho
        Storage::disk('public')->delete($marca->imagem);
        $imagem = $request->file('imagem');
        $imagem_urn= $imagem->store('imagens', 'public');
        $validated['imagem'] = $imagem_urn;
    }

        // Atualiza a marca no banco de dados
        $marca->update($validated);
    
        return response($marca,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca = $this->marca->findOrFail($id);
        
        Storage::disk('public')->delete($marca->imagem);
        $marca->delete();
        return response($marca,Response::HTTP_OK);
    }
}
