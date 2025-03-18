<?php

namespace App\Services;

use App\Models\ClientReview;
use Exception;

class ClientReviewService
{
    public function store($request)
    {
        // Implement logic to store worker review
        try {
            $clientReview = ClientReview::create([
                'reviewer_id' => $request->reviewer_id,
                'client_id' => $request->client_id,
                'rate' => $request->rate,
                'feedback_message' => $request->feedback_message,
                'metadata' => $request->questions ?? null,
            ]);

            return $clientReview;

        } catch (Exception $exception) {
            throw $exception;
        }

    }

    public function show($clientReviewId)
    {
        // Implement logic to show client reviews
        try {
            $clientReview = ClientReview::find($clientReviewId);
            if (!$clientReview) {
                throw new Exception('Review not found', 404);
            }

            return $clientReview;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function delete($clientReviewId)
    {
        try {
            $clientReview = ClientReview::find($clientReviewId);
            if (!$clientReview) {
                throw new Exception('Review not found', 404);
            }

            return $clientReview->delete();

        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
