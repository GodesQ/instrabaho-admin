<?php

namespace App\Services;

use App\Models\APIConsumer;

class APIConsumerService
{
    public function create($request)
    {
        $apiCode = generateAPICode();
        $apiKey = generateAPIKey();

        $data = $request->only('app_name', 'contact_email', 'contact_phone');

        $api_consumer = APIConsumer::create(array_merge($data, [
            'api_code' => $apiCode,
            'api_key' => $apiKey,
            'platform' => json_encode($request->platform)
        ]));

        return $api_consumer;
    }

    public function update($request, $id)
    {
        $apiConsumer = APIConsumer::findOrFail($id);
        $data = $request->only('app_name', 'contact_email', 'contact_phone');

        $apiConsumer->update(array_merge($data, [
            'platform' => json_encode($request->platform)
        ]));

        return $apiConsumer;
    }
}