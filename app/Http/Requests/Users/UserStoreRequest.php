<?php

namespace Spa\Http\Requests\Users;

use Spa\Http\Requests\BaseRequest;

class UserStoreRequest extends BaseRequest
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
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|string|email|unique:users,email',
            'password'   => 'required|string|confirmed',
        ];
    }
}
