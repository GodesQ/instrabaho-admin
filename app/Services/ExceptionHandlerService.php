<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class ExceptionHandlerService
{
    public function handler($request, Exception $exception)
    {

        if (config('app.debug')) {
            dd($exception);
        }

        if ($request->expectsJson()) {
            return $this->handleJSONResponse($exception);
        }

        return $this->handleHTMLResponse($exception);
    }

    public function handleJSONResponse(Exception $exception)
    {
        $resultCode = $this->getExceptionCode($exception);

        Log::error($exception->getMessage(), ['exception' => $exception]); // Logging error

        $result = [
            'error' => class_basename($exception),
            'message' => $resultCode == 500 ? self::serverErrorMessage() : ($exception->getMessage() ?? "Oops! Something wen't wrong. Please try again."),
        ];

        return response()->json($result, $resultCode);
    }

    public function handleHTMLResponse(Exception $exception)
    {
        return back()->with('failed', $exception->getMessage());
    }

    private function getExceptionCode(Exception $exception)
    {
        $exception_code = $exception->getCode();
        return empty($exception_code) || ! is_numeric($exception_code) ? 500 : (int) $exception_code;
    }

    private static function serverErrorMessage()
    {
        return "Server Error Found. Please screenshot this error/issue and contact customer service to resolve the issue.";
    }
}
