<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Http\Resources\UserResorces;
use App\Models\Rol;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $user)
    {
        $validateData = $user->validated();

        if ($validateData['confirm_password'] !== $validateData['password']) {
            return response()->json(['error' => 'Las contraseñas no coinciden'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $role = Rol::where('name', $validateData['role'])->first();

        $user = User::create([
            'name' => $validateData['name'],
            'surname' => $validateData['surname'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']),
            'rol_id' => $role->id
        ]);

        return response()->json([
            'message' => 'Usuario resgitrado correctamente',
            'data' => new UserResorces($user),
        ], Response::HTTP_CREATED);
    }

    public function status()
    {
        $user = auth()->user();

        $token = JWTAuth::getToken()->get();

        return response()->json([
            'message' => 'Usuario autenticado',
            'data' => new UserResorces($user),
            'token' => $token,
        ], Response::HTTP_OK);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->get();


        $credenciales = [
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ];

        try {

            if (!$token = JWTAuth::attempt($credenciales)) {
                return response()->json(["error" => 'Usuario o ontraseña invalido'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException) {
            return response()->json(["error" => 'No se puedo generar el token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            "message" => "Inicio de sesión exitoso",
            'data' =>  UserResorces::collection($user),
            'token' => $token
        ], Response::HTTP_ACCEPTED);

        // return response()->json($token);
    }

    public function logout()
    {
        try {

            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);

            return response()->json([
                'message' => 'Sesión cerrada con exito',
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'No se pud ocerrar sesión, el token no es valido'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
