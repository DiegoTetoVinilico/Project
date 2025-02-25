<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use \Symfony\Component\HttpFoundation\Response;

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
        return $marcas;
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
        //$marca = Marca::create($request->all());
        $marca = $this->marca->create($request->all());
        return response($marca,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null){
            return response(['erro' => 'Recurso pesquisado não existe'],Response::HTTP_NOT_FOUND);

            //Response::HTTP_NOT_FOUND;//response()->json(['erro' => 'Recurso pesquisado não existe'],);
        }

        return $marca;
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
        $marca = $this->marca->find($id);
        if($marca === null){
            return response(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'],Response::HTTP_NOT_FOUND);
        }
        $marca->updade($request->all());
        return $marca;
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
        return ['msg'=>'A marca foi removida com sucesso'];
    }
}
