<?php

namespace App\Observers;

use App\Models\Review;
use App\Models\ServiceRating;

class ReviewObserver
{
    /**
     * Handle the Review "created" event.
     */
    public function created(Review $review): void
    {
        $this->updateServiceRating($review->service_id);
    }

    private function updateServiceRating($service_id): void
    {
        $stats = Review::where('service_id', $service_id)
            ->selectRaw('AVG(rating) as average, COUNT(*) as total')
            ->first();

        $average = $stats->average ? round(min($stats->average, 5), 1) : 0;

        $total = $stats->total ?? 0;

        ServiceRating::updateOrCreate(
            ['service_id' => $service_id],
            [
                'average_rating' => $average,
                'total_reviews' => $total,
            ]
        );
    }
}
