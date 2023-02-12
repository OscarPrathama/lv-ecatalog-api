<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private UserRepository $userRepository, 
        private UserController $UserController,
        private AuthRepository $authRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->UserController = $UserController;
    }

    public function register(UserRequest $request): JsonResponse{
        
        try {

            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'city'      => $request->city
            ];

            $user = $this->userRepository->create($data);

            $tokenInstance = $this->authRepository->createAuthToken($user);

            $registered_user = $this->authRepository->getAuthData($user, $tokenInstance);

            return $this->responseSuccess('User registered successfully', $registered_user, Response::HTTP_CREATED);

        } catch (Exception $e) {
            return $this->responseError('Fail to create user', [], Response::HTTP_BAD_REQUEST);
        }

    }

}
