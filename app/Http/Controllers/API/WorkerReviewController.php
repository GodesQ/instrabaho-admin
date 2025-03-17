<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkerReview\StoreRequest;
use App\Http\Resources\WorkerReviewResource;
use App\Models\WorkerReview;
use App\Services\Handlers\ExceptionHandlerService;
use App\Services\WorkerReviewService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkerReviewController extends Controller
{
    protected $workerReviewService;
    public function __construct()
    {
        $this->workerReviewService = new WorkerReviewService();
    }

    public function store(StoreRequest $request)
    {
        try {
            $workerReview = $this->workerReviewService->store($request);

            $workerReview->load('worker.user', 'client.user');

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully.',
                'worker_review' => WorkerReviewResource::make($workerReview),
            ], Response::HTTP_CREATED);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function show(Request $request, $review_id)
    {
        try {

            $workerReview = WorkerReview::find($review_id);

            if (!$workerReview) {
                throw new Exception('Review not found', 404);
            }

            $workerReview->load('worker.user', 'client.user');

            return response()->json([
                'status' => true,
                'worker_review' => WorkerReviewResource::make($workerReview),
            ], Response::HTTP_OK);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function destroy(Request $request, $review_id)
    {
        try {
            $this->workerReviewService->delete($review_id);

            return response()->json([
                'status' => true,
                'message' => 'Review deleted successfully.',
            ], Response::HTTP_NO_CONTENT);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }

    }
}
