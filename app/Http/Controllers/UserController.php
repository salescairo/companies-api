<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Autenticar Usuários
     * @param \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) :JsonResponse
    {
        $user = User::where('email',$request->email)->first();
        if($user && Hash::check($request->password,$user->password) === TRUE){
            $token =  $user->createToken($user->name.'-'.$user->email);
            return response()->json(['token'=>$token->plainTextToken],401);
        }
        return response()->json('Login inválido',401);
    }
}
