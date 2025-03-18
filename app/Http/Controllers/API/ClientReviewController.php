<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientReview\StoreRequest;
use App\Http\Resources\ClientReviewResource;
use App\Services\ClientReviewService;
use App\Services\Handlers\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;

class ClientReviewController extends Controller
{
    protected $clientReviewService;
    public function __construct()
    {
        $this->clientReviewService = new ClientReviewService;
    }

    public function store(StoreRequest $request)
    {
        try {
            $clientReview = $this->clientReviewService->store($request);
            $clientReview->load('worker', 'client');

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully.',
                'client_review' => ClientReviewResource::make($clientReview),
            ], 201);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function show(Request $request, $clientReviewId)
    {
        try {
            $clientReview = $this->clientReviewService->show($clientReviewId);
            $clientReview->load('worker', 'client');

            return response()->json([
                'status' => true,
                'message' => 'Review submitted successfully.',
                'client_review' => ClientReviewResource::make($clientReview),
            ], 200);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }

    public function destroy(Request $request, $clientReviewId)
    {
        try {
            $this->clientReviewService->delete($clientReviewId);

            return response()->json([
                'status' => true,
                'message' => 'Review deleted successfully.',
            ], 204);

        } catch (Exception $exception) {
            $exceptionHandler = new ExceptionHandlerService;
            return $exceptionHandler->handler($request, $exception);
        }
    }
}
