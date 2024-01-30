<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdministradorFormRequest extends FormRequest
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
            'nome' => 'required|max:120|min:5',
            'email'  => 'required|max:120|email|unique:administradors,email,' . $this->id,
            'cpf' => 'required|max:11|min:11|unique:administradors,cpf,' . $this->id,
            'password' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => $validator->errors()
        ]));
    }

    public function messages()
    {
        return  [
            'nome.required' => 'Este campo é obrigatorio',
            'nome.max' => 'Este campo deve ter no maximo 120 caracteres',
            'nome.min' => 'Este campo deve ter ni minimo 5 caracteres',
            'cpf.required' => 'Este campo é obrigatorio',
            'cpf.max' => 'Este campo deve ter no maximo 11 caracteres',
            'cpf.min' => 'Este campo deve ter no maximo 11 caracteres',
            'cpf.unique' => 'Cpf já cadastrado',
            'email.required' => 'Este campo é obrigatorio',
            'email.unique' => 'Email já cadastrado',
            'password.required' => 'Este campo é obrigatorio',
            
            'email.email' => 'email invalido',
            'password.required'
        ];
    }
}
