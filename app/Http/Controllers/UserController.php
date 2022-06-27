<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Autenticar usuário
     * @param \Illuminate\Http\Request $request    
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) 
        {
            return response()->json('Credenciais inválidas', 400);
        }
        
        if (!Hash::check($request->password, $user->password)) 
        {
            return response()->json('Login inválido', 401);
        }

        $token =  $user->createToken($user->name . '-' . $user->email);
        return response()->json(['token' => $token->plainTextToken], 401);
    }

    /**
     * Retornar dados do usuário autenticado 
     * @param \Illuminate\Http\Request $request    
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user(), 200);
    }
    
    /**
     * Encerrar sessão do usuário autenticado 
     * @param \Illuminate\Http\Request $request    
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        if (!$request->user()) 
        {
            return response()->json('Token inválido', 401);
        }

        $request->user()->currentAccessToken()->delete();
        return response()->json('Sessão encerrada com sucesso!', 200);
    }
}
