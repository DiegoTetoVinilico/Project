<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModeloRequest extends FormRequest
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
            'marca_id' => 'exists:marcas,id',
            'nome' => [ 'required',
                        'min:3',
                        'max:100',
                        'unique:modelos'
                    ],
            'imagem' => 'required|image|mimes:jpeg,png,jpg',
            'numero_portas' => ['required',
                                'integer',
                                'digits_between:1,5',   
                                ],
            'lugares'=> ['required',
                         'integer',
                         'digits_between:1,20',
                        ],
            'air_bag'=> ['required',
                         'boolean'
                    ],
            'abs'=> ['required',
                         'boolean'
                        ]
        ];
        return $rules;
    }
    public function messages(): array
    {   
        $messages = [
            'marca_id.exists' => 'A marca selecionada não existe.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'nome.unique' => 'O nome já está cadastrado.',

            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem válida.',
            'imagem.mimes' => 'A imagem deve estar nos formatos: jpeg, png ou jpg.',

            'numero_portas.required' => 'O número de portas é obrigatório.',
            'numero_portas.integer' => 'O número de portas deve ser um valor inteiro.',
            'numero_portas.digits_between' => 'O número de portas deve ter entre :min e :max dígitos.',

            'lugares.required' => 'O número de lugares é obrigatório.',
            'lugares.integer' => 'O número de lugares deve ser um valor inteiro.',
            'lugares.digits_between' => 'O número de lugares deve ter entre :min e :max dígitos.',

            'air_bag.required' => 'O campo air bag é obrigatório.',
            'air_bag.boolean' => 'O campo air bag deve ser verdadeiro ou falso.',
            'abs.required' => 'O campo abs é obrigatório.',
            'abs.boolean' => 'O campo abs deve ser verdadeiro ou falso.',
        ];
        return $messages;
    }
}
