<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministradorFormRequest;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradorController extends Controller
{

    public function cadastrarAdm(AdministradorFormRequest $request)
    {
        $adm = Administrador::create([


            'nome' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password)


        ]);

        if(isset($adm)){

            return response()->json([
                'status' => true,
                'message' => 'Administrador Cadastrado com sucesso',
                'data' => $adm
    
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Administrador não foi cadastrado',
            'data' => $adm

        ], 200);

        
    }

    public function retornarTodosAdm()
    {
        $adm = Administrador::all();

        if (count($adm) > 0) {
            return response()->json([
                'status' => true,
                'data' => $adm
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => 'Não há nenhum administrador registrado'
        ]);
    }
    
    public function excluirAdm($id)
    {
        $adm = Administrador::find($id);

        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "Administrador não encontrado"
            ]);
        }

        $adm->delete();
        return response()->json([
            'status' => true,
            'message' => "Administrador excluido com sucesso"
        ]);
    }

    public function editarAdministrador(Request $request)
    {
        $adm = Administrador::find($request->id);
        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "Administrador não encontrado"
            ]);
        }

        if (isset($request->nome)) {
            $adm->nome = $request->nome;
        }

       
        if (isset($request->email)) {
            $adm->email = $request->email;
        }
        if (isset($request->cpf)) {
            $adm->cpf = $request->cpf;
        }

        $adm->update();

        return response()->json([
            'status' => true,
            'message' => 'Administrador atualizado.'
        ]);
    }



    public function recuperarSenha(Request $request)
    {

        $adm = Administrador::where('email', '=', $request->email)->first();

        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "Email invalido"

            ]);
        }
        if (isset($adm->cpf)) {
            $adm->password = Hash::make( $adm->cpf );
        }
        $adm->update();

        return response()->json([
            'status' => true,
            'password' => $adm->password
        ]);
    }
}