<?php

namespace App\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ServiceData extends Data
{
    public function __construct(
        public ?string $name,
        public ?string $desc,
        public ?int $price,
        public ?int $duration,
        public ?UploadedFile $img,
        public ?int $category_id,
    ) {}
}
