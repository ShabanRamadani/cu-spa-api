<?php

namespace Spa\Http\Requests\Events;

use Spa\Http\Requests\BaseRequest;

class EventStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string',
            'speaker_id'  => 'required|integer|exists:users,id',
            'location_id' => 'required|integer|exists:locations,id',
        ];
    }
}
