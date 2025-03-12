<?php

namespace App\Jobs;

use App\Services\ThirdParty\SemaphoreService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendUserRegistrationOTP implements ShouldQueue
{
    use Queueable;

    public $contact_number;
    public $country_code;
    /**
     * Create a new job instance.
     */
    public function __construct($country_code, $contact_number)
    {
        $this->country_code = $country_code;
        $this->contact_number = $contact_number;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $semaphoreService = new SemaphoreService;
        $response = $semaphoreService->sendOTP($this->country_code, $this->contact_number);
    }
}
