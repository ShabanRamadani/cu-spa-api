<?php

namespace Spa\Transformers;

use Spa\Models\Event;

class EventTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'speaker',
        'location',
    ];

    public function transform(Event $event)
    {
        $data = $this->transformColumns($event);

        return $data;
    }

    public function includeSpeaker(Event $event)
    {
        return $this->item($event->speaker, new UserTransformer, 'speaker');
    }

    public function includeLocation(Event $event)
    {
        return $this->item($event->location, new LocationTransformer, 'location');
    }

    protected function getTransformableColumns()
    {
        return [
            'id'          => 'id',
            'title'       => 'title',
            'description' => 'description',
            'created_at'  => 'created_at',
            'updated_at'  => 'updated_at',
        ];
    }

}