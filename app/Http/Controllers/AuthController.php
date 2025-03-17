<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login with a user account.
     */
    public function login(Request $request)
    {
        $messages = [
            'email.required' => 'O Email é obrigatório!',
            'email.max' => 'O Email deve ter menos de 255 caracteres!',
            'email.email' => 'O Email deve ser válido!',
            'email.exists' => 'Usuario não cadstrado!',
            'password.required' => 'A Senha é obrigatória!',
            'password.confirmed' => 'A Senha e Confirmação de Senha devem ser iguais!',
        ];

        $request->validate([
            'email' => 'required|max:255|email|exists:users',
            'password' => 'required',
        ], $messages);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'errors' => [
                    'password' => ['As credenciais estão incorretas!']
                ]
            ], 422)->header('Content-Type', 'application/json');
        }

        $token = $user->createToken($user->name);

        return [
            'token' => $token->plainTextToken
        ];
    }

    /**
     * Register a user.
     */
    public function register(Request $request)
    {
        $messages = [
            'name.required' => 'O Nome é obrigatório!',
            'name.max' => 'O Nome deve ter menos de 255 caracteres!',
            'email.required' => 'O Email é obrigatório!',
            'email.max' => 'O Email deve ter menos de 255 caracteres!',
            'email.email' => 'O Email deve ser válido!',
            'email.unique' => 'Este Email Já existe!',
            'file.required' => 'O Avatar de perfil é obrigatório!',
            'file.file' => 'O Avatar de perfil deve ser um arquivo válido!',
            'file.mimes' => 'O Avatar de perfil deve está somente em .png ou .jpg!',
            'file.max' => 'O Avatar de perfil deve ter menos de 10MB!',
            'password.required' => 'A Senha é obrigatória!',
            'password.confirmed' => 'A Senha e Confirmação de Senha devem ser iguais!',
        ];

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users',
            'file' => 'required|file|mimes:png,jpg|max:10240',
            'password' => 'required|confirmed'
        ], $messages);

        // http://localhost:8000/storage/uploads/{filename}
        $request->file('file')->storePublicly('uploads', 'public');
        $file_name = $request->file('file')->hashName();

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->avatar = $file_name;
        $user->password = $request->password;

        $user->save();

        $token = $user->createToken($request->name);

        return [
            'token' => $token->plainTextToken
        ];
    }

    /**
     * Logout with a user account.
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'Você saiu do sistema.'
        ];
    }
}
