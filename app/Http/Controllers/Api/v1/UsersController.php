<?php

namespace Spa\Http\Controllers\Api\v1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;
use Spa\Http\Controllers\Api\ApiController;
use Spa\Models\User;
use Spa\Transformers\UserTransformer;

class UsersController extends ApiController
{

    /**
     * @var \Spa\Transformers\UserTransformer
     */
    private $transformer;

    public function __construct(Response $response, UserTransformer $transformer)
    {
        parent::__construct($response);
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response->withPaginator(User::query()->paginate($request->get('limit') ?: 10), $this->transformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()->findOrFail($id);
        return $this->response->withItem($user, $this->transformer);
    }

}
