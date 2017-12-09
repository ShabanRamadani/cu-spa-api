<?php

namespace Spa\Listeners\Jwt;

class TokenAbsent extends TokenBase
{
    /**
     * @return array
     */
    public function handle()
    {
        return $this->response->errorUnauthorized('Token is absent.');
    }
}
