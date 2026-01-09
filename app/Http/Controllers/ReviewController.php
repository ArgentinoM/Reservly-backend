<?php

namespace App\Http\Controllers;

use App\Data\ReviewData;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\review\ReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResorces;
use App\Models\Review;
use App\Models\Services;
use App\Services\ReviewService;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{

    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function index(PaginateRequest $request, Services $service)
    {
        $validateData = $request->validated();

        $review = $service->reviews()
            ->paginate($validateData['perPage'] ?? 10);

        ReviewResorces::collection($review);

        return response()->json([
            'message' => 'Solicitud exitosa',
            'data' =>   $review->items(),
            'meta' => [
                'current_page' => $review->currentPage(),
                'last_page' => $review->lastPage(),
                'per_page' => $review->perPage(),
                'total' => $review->total()
            ]
        ], Response::HTTP_OK);
    }

    public function store(ReviewRequest $request, Services $service)
    {
        $validateData = $request->validated();

        $review = $this->reviewService->storeReview(
            ReviewData::from([
                'rating' => $validateData['rating'],
                'comment' => $validateData['comment'],
            ]), $service
        );

        return response()->json([
            'message' => 'Opinion creada exitosamente',
            'data' =>  new ReviewResorces($review)
        ], Response::HTTP_ACCEPTED);
    }

    public function update(UpdateReviewRequest $request, Review $review)
    {
        $validateData = $request->validated();

        $review = $this->reviewService->updateReview(
            $review,
            ReviewData::from([
                'comment' => $validateData['comment'],
            ])
        );

        return response()->json([
            'message' => 'Actualización exitosa',
            'data' =>  new ReviewResorces($review)
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy(Review $review)
    {

        $review = $this->reviewService->deleteReview($review);

        return response()->json([
            'message' => 'Se elimino el comentario',
        ], Response::HTTP_ACCEPTED);
    }
}
