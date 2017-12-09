<?php

namespace Spa\Listeners\Jwt;

class TokenInvalid extends TokenBase
{
    /**
     * @return array
     */
    public function handle()
    {
        return $this->response->errorUnauthorized('Token is invalid.');
    }
}
