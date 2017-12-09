<?php

namespace Spa\Http\Controllers\Api\v1;


use Illuminate\Http\Request;
use Spa\Http\Controllers\Api\ApiController;
use Spa\Http\Requests\Authentication\LoginRequest;
use Spa\Models\User;
use Spa\Transformers\UserTransformer;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
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

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->input('token');
            if (!$token) {
                $token = last(explode(' ', $request->header('Authorization')));
            }
            JWTAuth::invalidate($token);

            return response('', 201);
        } catch (TokenBlacklistedException $e) {
            return $this->response->errorUnauthorized($e->getMessage());
        } catch (JWTException $e) {
            return $this->response->errorInternalError($e->getMessage());
        }
    }

    public function me()
    {
        $user = JWTAuth::parseToken()->authenticate();

        return $this->response->withItem($user, new UserTransformer);
    }

}
