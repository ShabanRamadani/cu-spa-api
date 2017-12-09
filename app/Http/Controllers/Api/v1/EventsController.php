<?php

namespace Spa\Http\Controllers\Api\v1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spa\Http\Controllers\Api\ApiController;
use Spa\Http\Requests\Events\EventDeleteRequest;
use Spa\Http\Requests\Events\EventStoreRequest;
use Spa\Http\Requests\Events\EventUpdateRequest;
use Spa\Models\Event;
use Spa\Models\Location;
use Spa\Models\User;
use Spa\Transformers\EventTransformer;

class EventsController extends ApiController
{
    /**
     * @var \Spa\Transformers\UserTransformer
     */
    private $transformer;

    public function __construct(Response $response, EventTransformer $transformer)
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
        return $this->response->withPaginator(Event::query()->paginate($request->get('limit')
            ?: 10), $this->transformer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spa\Models\Event $event
     *
     * @return \Illuminate\Http\Response
     */
    public function show($event)
    {
        $event = Event::query()->findOrFail($event);

        return $this->response->withItem($event, $this->transformer);
    }

    /**
     * @param EventStoreRequest $request
     *
     * @return mixed
     */
    public function store(EventStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            /** @var Event $event */
            $event = Event::query()->make([
                'title'       => $request->get('title'),
                'description' => $request->get('description'),
            ]);

            $event->speaker()->associate(User::query()->findOrFail($request->get('speaker_id')));
            $event->location()->associate(Location::query()->findOrFail($request->get('location_id')));

            $event->save();
            DB::commit();

            return $this->response->withItem($event, $this->transformer);
        } catch (\Exception $exception) {
            return $this->response->errorInternalError($exception->getMessage());
        }
    }

    /**
     * @param EventUpdateRequest    $request
     * @param                       $event
     *
     * @return mixed
     */
    public function update(EventUpdateRequest $request, $event)
    {

        DB::beginTransaction();
        try {
            $event = Event::query()->findOrFail($event);
            $event->update($request->all());
            if ($request->get('speaker_id')) {
                $event->speaker()->associate(User::query()->findOrFail($request->get('speaker_id')));
            }
            if ($request->get('location_id')) {
                $event->location()->associate(Location::query()->findOrFail($request->get('location_id')));
            }
            $event->save();
            DB::commit();

            return $this->response->withItem($event->fresh(), $this->transformer);
        } catch (\Exception $exception) {
            DB::rollback();

            return $this->response->errorInternalError($exception->getMessage());
        }

    }

    /**
     * @param EventDeleteRequest    $request
     * @param                       $event
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(EventDeleteRequest $request, $event)
    {
        $event = Event::query()->findOrFail($event);
        $event->delete();

        return response()->json([], 204);
    }
}
