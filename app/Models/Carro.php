<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    /** @use HasFactory<\Database\Factories\CarroFactory> */
    use HasFactory;

    protected $fillable = ['modelo_id', 'placa', 'disponivel', 'km'];

    public function modelo(){
        return $this->belongsTo('App\Models\Modelo');
    }
}
