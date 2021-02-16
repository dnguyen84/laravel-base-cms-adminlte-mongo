<?php

namespace App;

use Cedu\Mongodb\Eloquent\Model;

class Embedded extends Model
{
    /**
     * Disable guarded fields
     */
    protected $guarded = [];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
