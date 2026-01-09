<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateUserRequest;
use App\Http\Resources\UserResorces;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = auth()->user();

        $user->fill($validatedData);

        if (!empty($validatedData['img_perfil'])) {
            if ($user->img_perfil) {
                Cloudinary()->uploadApi()->destroy($user->img_perfil);
            }

            $user->img_perfil = Cloudinary()->uploadApi()->upload($validatedData['img_perfil']->getRealPath(), [
                'public_id' => 'services-' . preg_replace('/[^A-Za-z0-9\-]/', '-', $user->name),
                'overwrite' => true,
            ])['secure_url'];
        }

        if ($user->isDirty()) {
            $user->save();
            return response()->json([
                'message' => 'Usuario actualizado correctamente',
                'data' => new UserResorces($user),
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'No se realizaron cambios',
        ], Response::HTTP_OK);
    }
}
