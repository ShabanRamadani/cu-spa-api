<?php

namespace Spa\Transformers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    protected function transformColumns(Model $model)
    {
        $data = [];
        foreach ($this->getTransformableColumns() as $attribute => $key) {
            if (array_key_exists($attribute, $model->getAttributes())) {
                if (in_array($key, $model['dates'])) {
                    $data[$key] = Carbon::parse($model->$attribute)->toIso8601String();
                } else {
                    $data[$key] = $model->$attribute;
                }
            }
        }

        return $data;
    }

    protected abstract function getTransformableColumns();
}