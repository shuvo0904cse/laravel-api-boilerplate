<?php


namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Message
{
    /**
     * Throw New Exception Message
     */
    public static function throwExceptionMessage($message= "")
    {
        throw new \Exception($message,Response::HTTP_BAD_REQUEST );
    }

    /**
     * Throw Exception
     */
    public static function throwException($exception)
    {
        $message = trans("message.400");
        if(!is_string($exception)){
            $message = $exception->getMessage();
            if($exception->getCode() == 0){
                $message = trans("message.400");
            }
        } else {
            $message = $exception;
        }
        throw new \Exception($message,Response::HTTP_BAD_REQUEST );
    }

    /**
     * Json Response
     */
    public static function jsonResponse($results = null)
    {
        return new JsonResponse($results, Response::HTTP_OK);
    }

    /**
     * Error Message
     */
    public static function errorMessage($message = null, $errors = null, $key = null, $results = "")
    {
        return new JsonResponse([
            'key'       => empty($key) ? config("settings.bad_request_key") : $key,
            'message'   => empty($message) ? trans("message.400") : $message,
            'errors'    => $errors,
            'results'   => $results,
            'timestamp' => Carbon::now(),
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Validation Error Message
     */
    public static function validationMessage($message = null, $errors = null)
    {
        return new JsonResponse([
            'key'       => config("settings.validation_key"),
            'message'   => empty($message) ? trans("message.invalid_input") : $message,
            'errors'    => $errors,
            'timestamp' => Carbon::now(),
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * http Response Exception
     */
    public static function httpResponseException($errors = [])
    {
        throw new HttpResponseException(self::validationMessage(null, $errors));
    }

    /**
     * Success Message
     */
    public static function successMessage($message = null, $results = null)
    {
        return new JsonResponse([
            'key'       => config("settings.success_key"),
            'message'   => empty($message) ? trans("message.executed_successfully") : $message,
            'results'   => $results,
            'timestamp' => Carbon::now()->toDateTimeString(),
        ], Response::HTTP_OK);
    }
}
