<?php

namespace Spa\Listeners\Jwt;

class TokenExpired extends TokenBase
{
    /**
     * @return array
     */
    public function handle()
    {
        return $this->response->errorUnauthorized('Token has expired.');
    }
}
