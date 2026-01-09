<?php

namespace App\Services;

use App\Data\ReviewData;
use App\Exceptions\ApiException;
use App\Models\Review;
use App\Models\Services;
use App\Models\User;

class ReviewService
{
    protected User $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function storeReview(ReviewData $data, Services $service): Review
    {
        $this->authorizeUser();
        $this->validateNoExistingReview($service->id);

        return $this->createReview($data, $service->id);
    }

    protected function createReview(ReviewData $data, int $service_id): Review
    {
        return Review::create([
            'rating' => $data->rating,
            'comment' => $data->comment ?? null,
            'user_id' => $this->user->id,
            'service_id' => $service_id
        ]);
    }

    public function updateReview(Review $review, ReviewData $data): Review
    {
        $this->authorizeOwner($review);

        $review->comment = $data->comment;

        $review->save();

        return $review;
    }


    public function deleteReview(Review $review): void
    {
        $this->authorizeOwner($review);

        $review->update(['comment' => null]);
    }

    protected function authorizeUser(): void
    {
        if ($this->user->rol_id === 1) {
            throw new ApiException(
                'No tienes autorización para realizar esta acción.'
            );
        }
    }

    protected function authorizeOwner(Review $review): void
    {
        if ($review->user_id !== $this->user->id) {
            throw new ApiException('No tienes autorización para modificar esta reseña.');
        }
    }

    protected function validateNoExistingReview(int $service_id): void
    {
        $review = $this->user->review()
            ->where('service_id', $service_id)
            ->exists();

        if ($review) {
            throw new ApiException(
                'Ya has dejado una reseña para este servicio.'
            );
        }
    }
}
