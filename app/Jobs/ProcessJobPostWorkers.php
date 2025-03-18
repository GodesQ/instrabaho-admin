<?php

namespace App\Jobs;

use App\Models\InterestedWorker;
use App\Models\JobPost;
use App\Models\JobRankedWorker;
use App\Models\User;
use App\Models\Worker;
use App\Notifications\WorkerJobPostNotification;
use App\Notifications\WorkerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessJobPostWorkers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobPost;

    /**
     * Create a new job instance.
     */
    public function __construct(JobPost $jobPost)
    {
        $this->jobPost = $jobPost;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $jobPost = $this->jobPost;
        // Step 1: Filter Workers
        $filteredWorkers = Worker::query()
            ->whereHas('worker_service', function ($query) use ($jobPost) {
                $query->where('service_id', $jobPost->service_id);
            })
            ->selectRaw("
                workers.*,
                ST_Distance_Sphere(
                    POINT(workers.longitude, workers.latitude),
                    POINT(?, ?)
                ) AS distance
            ", [$this->jobPost->longitude, $this->jobPost->latitude])
            ->having('distance', '<=', config('job_posting.max_distance', 3000))
            ->with('user')
            ->get();

        // Step 2: Score Workers
        $scoredWorkers = $filteredWorkers->map(function ($worker) {
            $totals = $this->calculateTotalScore($worker);
            return [
                'worker' => $worker,
                'proximity_total' => $totals['proximity_total'],
                'availability_total' => $totals['availability_total'],
                'skill_match_total' => $totals['skill_match_total'],
                'rating_total' => $totals['rating_total'],
                'total_score' => $totals['total_score'],
            ];
        });

        // Step 3: Notify Top Workers
        $topWorkers = $scoredWorkers->sortByDesc('total_score')->take(config('job_posting.top_workers_count'));
        foreach ($topWorkers as $workerData) {
            JobRankedWorker::create([
                'job_post_id' => $this->jobPost->id,
                'worker_id' => $workerData['worker']->id,
                'total_score' => $workerData['total_score'],
                'metadata' => json_encode([
                    'proximity_total' => $workerData['proximity_total'],
                    'availability_total' => $workerData['availability_total'],
                    'skill_match_total' => $workerData['skill_match_total'],
                    'rating_total' => $workerData['rating_total'],
                ])
            ]);

            if ($workerData['worker']->user) {
                // $workerData['worker']->user->notify(new WorkerJobPostNotification($this->jobPost));
            }
        }

    }

    private function calculateTotalScore($worker)
    {
        $proximityScore = $this->calculateProximityScore($worker->distance);
        $availabilityScore = 100; // All filtered workers are available
        $skillMatchScore = 100; // Exact skill match
        $ratingScore = rand(1, 100);
        // $ratingScore = max(($worker->rating - 4.5) * 100, 0);

        $proximityTotal = $proximityScore * config('job_posting.scoring_weights.proximity');
        $availabilityTotal = $availabilityScore * config('job_posting.scoring_weights.availability');
        $skillMatchTotal = $skillMatchScore * config('job_posting.scoring_weights.skill_match');
        $ratingTotal = $ratingScore * config('job_posting.scoring_weights.rating');

        $totalScore = $proximityTotal + $availabilityTotal + $skillMatchTotal + $ratingTotal;

        return [
            'total_score' => number_format($totalScore, 2),
            'proximity_total' => number_format($proximityTotal, 2),
            'availability_total' => number_format($availabilityTotal, 2),
            'skill_match_total' => number_format($skillMatchTotal, 2),
            'rating_total' => number_format($ratingTotal, 2),
        ];
    }

    private function calculateProximityScore($distance)
    {
        if ($distance <= 2000)
            return 100;
        if ($distance <= 4000)
            return 90;
        if ($distance <= 6000)
            return 80;
        if ($distance <= 10000)
            return 50;
        return 0;
    }
}
