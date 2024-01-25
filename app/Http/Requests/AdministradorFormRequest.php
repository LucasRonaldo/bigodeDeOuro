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
            'cpf' => 'required|numeric|max:99999999999|min:10000000000|unique:administradors,cpf,' . $this->id,
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
            'cpf.required' => 'Este campo é obrigatorio',
            'email.required' => 'Este campo é obrigatorio',
            'password.required' => 'Este campo é obrigatorio',
            'cpf.unique' => 'Cpf já cadastrado',
            'email.email' => 'email invalido',
            'password.required'
        ];
    }
}
