<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{

    use ResponseTrait;

    // /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string|null
    //  */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return $this->responseError([], "Unauthenticated access !");
    //     }
    // }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {

        throw new HttpResponseException(
            $this->responseError('Unauthenticated access', [], Response::HTTP_UNAUTHORIZED)
        );

    }

}
