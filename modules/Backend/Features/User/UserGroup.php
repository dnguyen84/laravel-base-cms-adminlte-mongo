<?php

namespace Modules\Backend\Features\User;

use App\Embedded;

/**
 * User group embeds
 */
class UserGroup extends Embedded
{
    /**
     * The attributes that are mass assignable.
     *
     * We can use {code,name,mobile} to login
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'kind',
        'role',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'id'    => null,
        'kind'  => null,
        'role'  => null,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Create resource embed from input
     * @example $group = UserGroup::from($data);
     */
    public static function from($data)
    {
        $static = new static;
        $static->fill((array) $data);
        return $static;
    }
}