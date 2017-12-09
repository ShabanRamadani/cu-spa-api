<?php

namespace Spa\Http\Requests;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * @var Response
     */
    protected $apiResponse;

    public function __construct()
    {
        parent::__construct();
        $this->apiResponse = app(Response::class);
    }

    public function response(array $errors)
    {
        return $this->apiResponse->errorWrongArgs($errors);
    }

    public function forbiddenResponse()
    {
        return $this->apiResponse->errorForbidden('Forbidden');
    }
}
