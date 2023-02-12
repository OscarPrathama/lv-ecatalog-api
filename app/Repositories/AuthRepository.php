<?php

namespace App\Repositories;

use App\Interfaces\CrudInterface;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository
{
    public function login(array $data): array{
        
        // check the user email
        $user = $this->getUserByEmail($data['email']);
        if(!$user){
            throw new Exception("Email doesn't register", 404);
        }
    
        // check the user password
        if(!$this->isValidPassword($user, $data)){
            throw new Exception("Sorry, password doesn't match", 401);
        }
        $tokenInstance = $this->createAuthToken($user);

        return $this->getAuthData($user, $tokenInstance);
    }

    public function getUserByEmail(string $email): ?User{
        return User::where('email', $email)->first();
    }

    public function isValidPassword(User $user, array $data): bool{
        return Hash::check($data['password'], $user->password);
    }

    public function createAuthToken(User $user): PersonalAccessTokenResult{
        return $user->createToken('authToken');
    }

    public function getAuthData(User $user, PersonalAccessTokenResult $tokenInstance){
        return [
            'user'  => $user,
            'access_token' => $tokenInstance->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenInstance->token->expires_at)->toDateTimeString(), // format -> 2024-02-03 02:55:01
        ];
    }

}
?>