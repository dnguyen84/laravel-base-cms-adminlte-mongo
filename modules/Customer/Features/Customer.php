<?php

namespace Modules\Customer\Features;

use App\Model;
use App\Traits\Castable;
use App\Traits\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * Save system setting here
 */
class Customer extends Model
{
    /* protected $connection = 'mongodb';*/
    protected $collection = 'sage.users';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    const DELETED_AT = 'deleted';

    use SoftDeletes;
    use Castable;
    use SettingEvent;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '_id',          // string   sage.users _id
        'id',          // string   sage.users id
        'name',         // string   setting name
        'email',        // string
        'username',        // string
        'nickname',        // string
        'about',      // array
        'avatar',      // int
        'cover',       // int
        'entities',       // int
        'location',       // int
        'timezone',       // int
        'privacy',       // int
        'profile',       // int
        'attributes',       // int
        'settings',       // int
        'relations',       // int
        'hashtags',       // int
        'labels',       // int
        'lang',       // int
        'verified',       // int
        'protected',       // int
        'active',       // int
        'createdAt',       // int
        'updatedAt',       // int
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'integer',
        'verified' => 'integer',
        'protected' => 'integer',
    ];

    /**
     * Get value with text format
     * @example $setting->valueText
     */
    public function getValueTextAttribute()
    {
        if ($this->format == 'json') {
            return json_encode($this->value, JSON_PRETTY_PRINT);
        }

        return $this->value;
    }

    /**
     * Get a setting value by key with default value
     * @example Setting::get('content.limit', 20);
     */
    public static function get($key, $default = null)
    {
        $setting = self::find($key);
        if (empty($setting)) {
            return $default;
        }

        return $setting->value ?? $default;
    }

    /**
     * Get a setting value by key and merge with array
     */
    public static function merge($key, $merge = [])
    {
        return array_merge(self::get($key, []), $merge);
    }

    /**
     * Get or create new setting
     */
    public static function firstOrCreate($data)
    {
        $guid    = Arr::get($data, 'id');
        $customer = self::find($guid);

        if ($customer) {
            return $customer;
        }

        $customer         = new Customer();
        $customer->_id    = $guid;
        $customer->name   = '';
        $customer->email = '';
        $customer->username  = '';
        $customer->nickname  = '';
        $customer->fill(Arr::only($data, $customer->getFillable()));
        $customer->save();

        return $customer;
    }
}