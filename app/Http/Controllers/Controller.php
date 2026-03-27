<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
abstract class Controller
{
   protected function sendSuccessResponse($data = null, $message = 'Success!!', $status = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data, 'type' => 'success'], $status);
    }

    protected function sendErrorResponse($message = 'Error!!', $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['message' => $message, 'type' => 'error'], $status);
    }
}
