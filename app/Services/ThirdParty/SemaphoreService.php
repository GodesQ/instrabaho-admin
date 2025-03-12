<?php

namespace App\Services\ThirdParty;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use GuzzleHttp\Client;

class SemaphoreService
{
    public function sendOTP($country_code, $contact_number)
    {
        // try {
        //     $response = Http::asForm()->post('https://api.semaphore.co/api/v4/otp', [
        //         'apikey' => env('SEMAPHORE_API_KEY'),
        //         'number' => "+" . $country_code . $contact_number,
        //         'message' => 'Thanks for registering in Instrabaho. Your OTP Code is {otp}.',
        //         'sendername' => "Instrabaho"
        //     ]);

        //     if ($response->successful()) {
        //         $content = $response->getBody()->getContents();

        //         if (!empty($data)) {
        //             Log::info('OTP Response:', [$content]); // Log the first item in the response array
        //         }

        //         return $content; // Return the first response object
        //     }

        //     Log::error('Failed to send OTP.', ['response' => $response->body()]);
        //     throw new Exception('Failed to send OTP.', 500);
        // } catch (Exception $exception) {
        //     throw $exception;
        // }

        // dd($contact_number);
        $client = new Client();

        $parameters = [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => '09633987953',
            'message' => 'I just sent my first message with Semaphore',
            'sendername' => 'Instrabaho'
        ];

        try {
            $response = $client->request('POST', 'https://semaphore.co/api/v4/messages', [
                'form_params' => $parameters
            ]);

            $output = $response->getBody()->getContents();

            // Show the server response
            return $output;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
