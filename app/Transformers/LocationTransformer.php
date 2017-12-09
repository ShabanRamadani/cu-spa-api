<?php

namespace Spa\Transformers;

use Spa\Models\Location;

class LocationTransformer extends BaseTransformer
{
    protected $availableIncludes = [

    ];

    public function transform(Location $location)
    {
        $data = $this->transformColumns($location);

        return $data;
    }


    protected function getTransformableColumns()
    {
        return [
            'id'         => 'id',
            'name'       => 'name',
            'address'    => 'address',
            'latitude'   => 'latitude',
            'longitude'  => 'longitude',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
    }

}