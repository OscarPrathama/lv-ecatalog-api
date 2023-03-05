<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use ResponseTrait;

    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = $this->userRepository->getAll(request()->all());
            return $this->responseSuccess('', $users);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'city'      => $request->city
            ];

            $user = $this->userRepository->create($data);
            return $this->responseSuccess('', $user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->responseSuccess('', $this->userRepository->getById($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), 'User doesn\'t exist.',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display current login user
     *
     * @return JsonResponse
     */
    public function myProfile(): JsonResponse
    {
        try {
            return $this->responseSuccess('Get authenticated user success', Auth::guard()->user());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), 'User doesn\'t exist.',Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     * belum, cek jga klo ganti pass, cek login kembali
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {

        try {

            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'city'      => $request->city
            ];

            return $this->responseSuccess('', $this->userRepository->update($id, $data));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), null,Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return $this->responseSuccess('User deleted successfully', $this->userRepository->delete($id));
        } catch (Exception $e) {
            return $this->responseError($e->getMessage(), null,Response::HTTP_NOT_FOUND);
        }
    }
}
