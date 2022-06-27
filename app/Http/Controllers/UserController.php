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

        //IF USER EXISTS AND PASSWORD VERIFICATION IS VALID
        if ($user && Hash::check($request->password, $user->password) === TRUE) {
            //RETURN TOKEN
            $token =  $user->createToken($user->name . '-' . $user->email);
            return response()->json(['token' => $token->plainTextToken], 401);
        }
        //RETURN FORBIDDEN STATUS
        return response()->json('Login inválido', 401);
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
}
