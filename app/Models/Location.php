<?php

namespace Spa\Models;


class Location extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

}
