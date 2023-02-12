<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\AuthRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct(private AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Login
     *
     * @param   LoginRequest $request
     * @return  JsonResponse
     */
    public function login(LoginRequest $request){
        
        try {
            $user = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            $data = $this->auth->login($user);
            return $this->responseSuccess('Logged in successfully', $data);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), [], Response::HTTP_BAD_REQUEST);
        }

    }

    public function logout(): JsonResponse
    {
        try {
            Auth::guard()->user()->token()->revoke();
            Auth::guard()->user()->token()->delete();
            return $this->responseSuccess('User logged out successfully');
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

}
