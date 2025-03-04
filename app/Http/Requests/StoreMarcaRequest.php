<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarcaRequest extends FormRequest
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
        return [
            'nome' => [ 'required',
                        'min:3',
                        'max:100',
                        'unique:marcas'
                    ],
            'imagem' => 'required|image|mimes:jpeg,png,jpg',
        ];
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

    protected function prepareForValidation()
    {
        $this->merge([
            'imagem' => $this->imagem ?? null, // Garante que o campo 'imagem' esteja presente
        ]);
    }
}
