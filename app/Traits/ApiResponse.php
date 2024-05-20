<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{
    /**
     * Success Response.
     *
     * @param $data, $message
     * @return JsonResponse
     */
    public function successResponse(mixed $data, string $message): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'status'   => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Error Response.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function errorResponse(mixed $data, string $message = '', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        if (!$message) {
            $message = Response::$statusTexts[$statusCode];
        }

        $data = [
            'message' => $message,
            'errors' => $data,
        ];

        return new JsonResponse($data, $statusCode);
    }

    /**
     * Response with status code 400.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function badRequestResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Response with status code 401.
     *
     * @param  mixed  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function unauthorizedResponse(mixed $data, string $message = ''): JsonResponse
    {
        return $this->errorResponse($data, $message, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Response with status code 404.
     *
     * @param $data, $message
     * @return JsonResponse
     */
    public function notFoundResponse(mixed $data, string $message): JsonResponse
    {
        return response()->json([
            'code' => Response::HTTP_NOT_FOUND,
            'status'    => 'failed',
            'message' => $message,
            'data' => $data
        ],  Response::HTTP_NOT_FOUND);
    }

    /**
     * Response with status code 422.
     *
     * @param  $data, $message
     * @return JsonResponse
     */
    public function unprocessableResponse(mixed $data, string $message): JsonResponse
    {
        $errors = $this->getErrors($data);

        return response()->json([
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            'status' => 'failed',
            'message' => $message,
            'errors' => $errors,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
    * Transform array to object validation errors
    * 
    * @param  mixed $errors
    * @return object
    */
    private function getErrors($errors)
    {
        return collect($errors)
                ->map(fn($error) => $error[0]);
    }
}