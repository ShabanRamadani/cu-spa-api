<?php

namespace Spa\Transformers;

use League\Fractal\Serializer\ArraySerializer;

class Serializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        if ($resourceKey === null) {
            return ['data' => $data];
        } else {
            return $data;
        }
    }

}