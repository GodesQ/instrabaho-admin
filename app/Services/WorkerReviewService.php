<?php

namespace App\Services;

use App\Models\WorkerReview;
use Exception;

class WorkerReviewService
{
    public function store($request)
    {
        // Implement logic to store worker review
        try {
            $workerReview = WorkerReview::create([
                'reviewer_id' => $request->reviewer_id,
                'worker_id' => $request->worker_id,
                'rate' => $request->rate,
                'feedback_message' => $request->feedback_message,
                'metadata' => $request->questions ?? null,
            ]);

            return $workerReview;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function delete($review_id)
    {
        try {
            $workerReview = WorkerReview::find($review_id);

            if (!$workerReview) {
                throw new Exception('Review not found', 404);
            }

            return $workerReview->delete();

        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
