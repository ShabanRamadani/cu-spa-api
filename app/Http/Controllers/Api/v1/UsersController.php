<?php

namespace Spa\Http\Controllers\Api\v1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;
use Spa\Http\Controllers\Api\ApiController;
use Spa\Http\Requests\Users\UserDeleteRequest;
use Spa\Http\Requests\Users\UserStoreRequest;
use Spa\Http\Requests\Users\UserUpdateRequest;
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
        return $this->response->withPaginator(User::query()->paginate($request->get('limit')
            ?: 10), $this->transformer);
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

    /**
     * @param UserStoreRequest $request
     *
     * @return mixed
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::query()->create($request->all());

        return $this->response->withItem($user, $this->transformer);
    }

    /**
     * @param UserUpdateRequest $request
     * @param                   $user
     *
     * @return mixed
     */
    public function update(UserUpdateRequest $request, $user)
    {
        $user = User::query()->findOrFail($user);
        $user->update($request->all());

        return $this->response->withItem($user->fresh(), $this->transformer);
    }

    /**
     * @param UserDeleteRequest $request
     * @param                   $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(UserDeleteRequest $request, $user)
    {
        $user = User::query()->findOrFail($user);
        $user->delete();

        return response()->json([], 204);
    }

}
