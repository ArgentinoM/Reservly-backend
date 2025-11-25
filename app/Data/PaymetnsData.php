<?php

namespace App\Data;

use Spatie\LaravelData\Data;


class PaymetnsData extends Data
{
    public function __construct(
        public int $service_id,
        public string $start_date,
        public string $end_date,
    ) {}
}
