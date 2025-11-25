<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = DB::table('services')->pluck('id');

        foreach ($services as $serviceId) {

            $ratings = DB::table('reviews')
                ->where('service_id', $serviceId)
                ->pluck('rating');


            if ($ratings->count() === 0) {
                continue;
            }


            $averageRating = round($ratings->avg(), 2);
            $totalReviews = $ratings->count();

            DB::table('service_ratings')->updateOrInsert(
                ['service_id' => $serviceId],
                [
                    'average_rating' => $averageRating,
                    'total_reviews'  => $totalReviews
                ]
            );
        }
    }
}
