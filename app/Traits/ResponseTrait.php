<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ResponseTrait
{
    
        
    /**
     * Success response
     *
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    public function responseSuccess(string $message, $data = [], int $code = Response::HTTP_OK): JsonResponse{
        $message = !empty($message) ? $message : 'success' ;
        
        return response()->json([
            'message'   => $message,
            'code'      => $code,
            'status'    => true,
            'data'      => $data
        ], $code);
    }
    
    /**
     * Error response
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function responseError(string $message = 'Something going wrong!.', $errors = [],int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse{
        return response()->json([
            'code'      => $code,
            'status'    => false,
            'message'   => $message,
            'errors'    => $errors 
        ], $code);
    }

}
?>