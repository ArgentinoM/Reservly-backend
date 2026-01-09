<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResorces extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'img_perfil' => $this->img_perfil,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'rol' => $this->rol,
        ];
    }
}
