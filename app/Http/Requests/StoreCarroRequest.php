<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'modelo_id' => 'exists:modelos,id',
            'placa'     => ['required',
                            'unique:carros'],
            'disponivel'=> ['required',
                            'boolean'
                            ],
            'km'        =>  'required'       
        ];
        return $rules;
    }
    public function messages(): array
    {
        return [
            'modelo_id.exists'   => 'O modelo informado não existe. Escolha um modelo válido.',
            'placa.required'     => 'O campo "placa" é obrigatório. Informe a placa do veículo.',
            'placa.unique'       => 'A placa informada já está cadastrada. Verifique se está correta ou utilize outra.',
            'disponivel.required'=> 'O campo "disponível" é obrigatório. Informe se o carro está disponível para uso.',
            'disponivel.boolean' => 'O campo "disponível" deve ser verdadeiro (true) ou falso (false).',
            'km.required'        => 'O campo "quilometragem" é obrigatório. Informe a quilometragem atual do veículo.',
        ];
    }
}
