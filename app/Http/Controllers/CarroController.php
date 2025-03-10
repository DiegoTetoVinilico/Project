<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use App\Repositories\CarroRepository;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use \Symfony\Component\HttpFoundation\Response;

class CarroController extends Controller
{   
    protected $carro;
    public function __construct(Carro $carro){
        $this->carro = $carro;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);
        
        if($request->has("atributos_modelo")){
            $atributos_modelo = 'modelo:id,'.$request->atributos_modelo; //recebe os dados do atributos_marca
           $carroRepository->selectAtributosRegistrosRelacionados($atributos_modelo);
        }else{
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if($request->has("filtro")){
            $carroRepository->filtro($request->filtro);
        }
        if($request->has("atributos")){
            $carroRepository->selectAtributos($request->atributos);
        }
        return response($carroRepository->getResultado(),Response::HTTP_OK);
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
    public function store(StoreCarroRequest $request)
    {
        $validated = $request->validated();
        #Stateless
        /*No caso de não passar na validação, ocorre o Stateless (Sem estado).
        Não mantém informações sobre o estado de uma conexão ou sessão.
        Por padrão, o usuário será redirecionado para a rota padrão
        */

        $carro = $this->carro->create($validated);

        return response($carro,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->findOrFail($id);

        return response($carro,Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarroRequest $request, $id)
    {
        
        // Encontra a marca pelo ID ou retorna erro 404
        $carro = $this->carro->findOrFail($id);

        //Valida os dados da requisição
        $validated = $request->validated();
     
        $carro->fill($validated);
        $carro->save();
    
        return response($carro,Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $carro = $this->carro->findOrFail($id);

        $carro->delete();
        return response($carro,Response::HTTP_OK); 
    }
}
