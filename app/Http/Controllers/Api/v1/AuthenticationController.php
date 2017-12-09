<?php

namespace Spa\Http\Controllers\Api\v1;


use Spa\Http\Controllers\Api\ApiController;
use Spa\Http\Requests\Authentication\LoginRequest;
use Spa\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends ApiController
{
    /**
     * @param \Spa\Http\Requests\Authentication\LoginRequest $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::query()->where('email', $credentials['email'])->first();

        if (!$user) {
            return $this->response->errorUnauthorized(trans('auth.failed'));
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->response->errorUnauthorized(trans('auth.failed'));
            }
        } catch (JWTException $e) {
            return $this->response->errorInternalError($e->getMessage());
        }

        return response(compact('token'));
    }
}
