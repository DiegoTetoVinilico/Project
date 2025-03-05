<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMarcaRequest extends FormRequest
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
            'nome' => [
                'sometimes', // O campo 'nome' é opcional no PATCH
                'min:3',
                'max:100',
                Rule::unique('marcas', 'nome')->ignore($this->id), // Ignora o próprio registro
            ],
            'imagem' => 'sometimes|image|mimes:jpeg,png,jpg,gif', // O campo 'imagem' é opcional no PATCH
        ];
    
        // Se for uma requisição POST, o campo 'nome' e 'imagem' são obrigatórios
        if ($this->method() == 'POST') {
            $rules['nome'][] = 'required';
            $rules['imagem'][] = 'required';
        }
    
        return $rules;
    }
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatorio',
            'nome.unique' => 'O campo nome da marca ja existe',
            'nome.min' => 'O nome deve ter no minimo 3 caracteres',
            'nome.max' => 'O nome deve ter no maximo 100 caracteres',
            'imagem.required' => 'O campo imagem é obrigatorio',
            'imagem.image' => 'O arquivo deve ser uma imagem válida',
            'imagem.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif',
        ];
    }
}
