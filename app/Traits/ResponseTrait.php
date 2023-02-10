<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    
        
    /**
     * Success response
     *
     * @param  mixed $data
     * @param  string $message
     * @return JsonResponse
     */
    public function responseSuccess($data, string $message = 'Successful'): JsonResponse{
        return response()->json([
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
            'errors'    => null
        ], Response::HTTP_OK);
    }
    
    /**
     * Error response
     *
     * @param  mixed $errors
     * @param  string $message
     * @param  int $responseCode
     * @return JsonResponse
     */
    public function responseError($errors, string $message = 'Something going wrong!.', int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse{
        return response()->json([
            'status'    => false,
            'message'   => $message,
            'data'      => null,
            'errors'    => $errors
        ], $responseCode);
    }

}
?>