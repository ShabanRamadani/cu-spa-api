<?php

namespace Spa\Models;

class Event extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    protected $guarded = [
        'speaker_id',
        'location_id',
    ];

    public function speaker()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
