<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicesResorces extends JsonResource
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
            'desc' => $this->desc,
            'price' => $this->price,
            'duration' => $this->duration,
            'img' => $this->img,
            'user' => $this->user->name,
            'category' => $this->category->id,
            'rating' => new RatingResorces($this->rating)
        ];
    }
}
