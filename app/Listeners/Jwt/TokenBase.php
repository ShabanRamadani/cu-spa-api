<?php
namespace Spa\Listeners\Jwt;

use EllipseSynergie\ApiResponse\Contracts\Response as ApiResponse;

class TokenBase
{
    /**
     * @var ApiResponse
     */
    protected $response;

    /**
     * TokenBase constructor.
     *
     * @param ApiResponse $response
     */
    public function __construct(ApiResponse $response)
    {
        $this->response = $response;
    }
}