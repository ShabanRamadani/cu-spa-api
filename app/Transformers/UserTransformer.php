<?php

namespace Spa\Transformers;

use Spa\Models\User;

class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = [

    ];

    public function transform(User $user)
    {
        $data = $this->transformColumns($user);

        return $data;
    }


    protected function getTransformableColumns()
    {
        return [
            'id'         => 'id',
            'first_name' => 'first_name',
            'last_name'  => 'last_name',
            'email'      => 'email',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
    }

}