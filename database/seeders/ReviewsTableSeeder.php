<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Review;
// ...

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = [1, 2, 3, 4, 5];


        $serviceIds = DB::table('services')->pluck('id')->all();


        foreach ($serviceIds as $serviceId) {

            Review::updateOrCreate(
                ['service_id' => $serviceId],
                [
                    'rating' => fake()->numberBetween(1, 5),
                    'comment' => fake()->realText(100),
                    'user_id' => fake()->randomElement($userIds),
                    'service_id' => $serviceId
                ]
            );
        }
    }
}
