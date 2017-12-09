<?php

namespace Spa\Http\Requests\Users;

use Spa\Http\Requests\BaseRequest;

class UserUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return intval($this->user) === intval($this->get('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'         => 'required|integer|exists:users,id',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|string|email|unique:users,email,' . $this->get('id'),
        ];
    }
}
