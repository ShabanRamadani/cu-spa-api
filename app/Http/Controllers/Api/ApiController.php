<?php

namespace Spa\Http\Controllers\Api;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var \EllipseSynergie\ApiResponse\Contracts\Response
     */
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
