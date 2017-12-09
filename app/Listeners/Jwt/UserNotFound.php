<?php

namespace Spa\Listeners\Jwt;

class UserNotFound extends TokenBase
{
    /**
     * @return array
     */
    public function handle()
    {
        return $this->response->errorUnauthorized('Token is orphan.');
    }
}
