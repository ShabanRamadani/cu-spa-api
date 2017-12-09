<?php

namespace Spa\Http\Requests\Events;

use Spa\Http\Requests\BaseRequest;

class EventUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return intval($this->event) === intval($this->get('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => 'required|integer|exists:events,id',
            'title'       => 'required|string',
            'description' => 'required|string',
            'speaker_id'  => 'required|integer|exists:users,id',
            'location_id' => 'required|integer|exists:locations,id',
        ];
    }
}
