<?php

namespace Spa\Http\Controllers\Api\v1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;
use Spa\Http\Controllers\Api\ApiController;
use Spa\Http\Requests\Locations\LocationDeleteRequest;
use Spa\Http\Requests\Locations\LocationStoreRequest;
use Spa\Http\Requests\Locations\LocationUpdateRequest;
use Spa\Models\Location;
use Spa\Transformers\LocationTransformer;

class LocationsController extends ApiController
{
    /**
     * @var \Spa\Transformers\UserTransformer
     */
    private $transformer;

    public function __construct(Response $response, LocationTransformer $transformer)
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
        return $this->response->withPaginator(Location::query()->paginate($request->get('limit')
            ?: 10), $this->transformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spa\Models\Location $location
     *
     * @return \Illuminate\Http\Response
     */
    public function show($location)
    {
        $location = Location::query()->findOrFail($location);

        return $this->response->withItem($location, $this->transformer);
    }

    /**
     * @param LocationStoreRequest $request
     *
     * @return mixed
     */
    public function store(LocationStoreRequest $request)
    {
        $location = Location::query()->create($request->all());

        return $this->response->withItem($location, $this->transformer);
    }

    /**
     * @param LocationUpdateRequest $request
     * @param                       $location
     *
     * @return mixed
     */
    public function update(LocationUpdateRequest $request, $location)
    {
        $location = Location::query()->findOrFail($location);
        $location->update($request->all());

        return $this->response->withItem($location->fresh(), $this->transformer);
    }

    /**
     * @param LocationDeleteRequest $request
     * @param                       $location
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LocationDeleteRequest $request, $location)
    {
        /** @var Location $location */
        $location = Location::query()->findOrFail($location);

        if ($location->events()->count() > 0) {
            return $this->response->errorWrongArgs(trans('exceptions.cant_delete_location_with_events'));
        }

        $location->delete();

        return response()->json([], 204);
    }

}
