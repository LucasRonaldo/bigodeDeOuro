<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormaDePagamentoFormRequest;
use App\Models\FormaDePagamento;
use Illuminate\Http\Request;

class FormaDePagamentoController extends Controller
{

    public function cadastrarTiposDePagamento(FormaDePagamentoFormRequest $request)
    {


        $pagamento = FormaDePagamento::create([
            'tipos_de_pagamento' => $request->tipos_de_pagamento,
            'status_do_pagamento' => $request->status_do_pagamento,
            'taxa' => $request->taxa
        ]);

        if (isset($pagamento)) {

            return response()->json([
                'status' => true,
                'message' => 'Forma de Pagamento Cadastrado com sucesso',
                'data' => $pagamento

            ], 200);
        }
        if (!isset($pagamento)) {
            return response()->json([
                'status' => false,
                'message' => 'Forma de Pagamento não foi cadastrado',
                'data' => $pagamento

            ], 200);
        }
    }

    public function retornarFormasDePagamento()
    {
        $pagamento = FormaDePagamento::all();

        if (count($pagamento) > 0) {
            return response()->json([
                'status' => true,
                'data' => $pagamento
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => 'Não há nenhuma forma de pagamento registradaS'
        ]);
    }

    public function excluirFormaDePagamento($id)
    {
        $pagamento = FormaDePagamento::find($id);
        $tipoDePagamento = $pagamento->tipos_de_pagamento;

        if (!isset($pagamento) || $pagamento == 0) {
            return response()->json([
                'status' => false,
                'message' => "Nenhum tipo de pagamento encontrado"
            ]);
        }

        $pagamento->delete();
        return response()->json([
            'status' => true,
            'message' => "Tipo de Pagamento: " . $tipoDePagamento . "\n excluido com sucesso"
        ]);
    }
}
