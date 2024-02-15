<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministradorFormRequest;
use App\Http\Requests\AdministradorUpdateFormRequest;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (isset($adm)) {

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

    public function editarAdm(AdministradorUpdateFormRequest $request)
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

        $adm = Administrador::where('cpf', '=', $request->cpf)->first();

        if (!isset($adm)) {
            return response()->json([
                'status' => false,
                'message' => "cpf nao encontrado"

            ]);
        }
        if (!isset($request->password)) {
            return response()->json([
                'status' => false,
                'message' => "Escreva a nova senha"

            ]);
        }
        if (isset($request->password)) {
            $adm->password = $request->password; //Hash::make( $request->password );
        }
        $adm->update();

        return response()->json([
            'status' => true,
            'password' => Hash::make($adm->password)
        ]);
    }


    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $data['password'] = Hash::make($request->password);

            $response = Administrador::create($data)->createToken($request->server('HTTP_USER_AGENT'))->plainTextToken;

            return response()->json([
                'status'=>'success',
                'message'=> "Admin cadastrado com sucesso",
                'token'=> $response
            ], 200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        try{
            

            if(Auth::guard('admins')->attempt([
                'email'=>$request->email, 
                'password' => $request->password
            ])) {
                $user = Auth::guard('admins')->user();

                $token = $user->createToken($request->server('HTTP_USER_AGENT', 
                ['admins']))->plainTextToken; 

                return response()->json([
                    'status' => true,
                    'message' => 'login efetuado com sucesso',
                    'token' => $token

                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Credenciais incorretas.',
                ]);
            }

        } catch(\Throwable $th){
            return response()->json([
                'status' => 'false',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function verificaUsuarioLogado(){
        return Auth::user();
    }
}
