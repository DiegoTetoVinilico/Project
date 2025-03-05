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

        $marca = $this->marca->create([
                                        'nome' => $validated['nome'],
                                        'imagem' => $imagem_urn
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
        // Valida os dados da requisição
        $validated = $request->validated();

    // Encontra a marca pelo ID ou retorna erro 404
        $marca = $this->marca->findOrFail($id);

    // Verifica se uma nova imagem foi enviada
    if ($request->hasFile('imagem')) {
        // Armazena a nova imagem no disco 'public' e obtém o caminho
        $imagem_urn = $request->file('imagem')->store('imagens', 'public');

        // Remove a imagem antiga (se existir)
        if ($marca->imagem && Storage::disk('public')->exists($marca->imagem)) {
            Storage::disk('public')->delete($marca->imagem);
        }

        // Atualiza o caminho da nova imagem no array de dados validados
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
        $marca = $this->marca->find($id);
        if($marca === null){
            return response(['erro' => 'Impossível realizar a exclusão. O recurso pesquisado não existe'],Response::HTTP_NOT_FOUND);
        }
        $marca->delete();
        return response($marca,Response::HTTP_OK);
    }
}
