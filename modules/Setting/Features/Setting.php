<?php

namespace Modules\Setting\Features;

use App\Model;
use App\Traits\Castable;
use App\Traits\SoftDeletes;
use Illuminate\Support\Arr;

/**
 * Save system setting here
 */
class Setting extends Model
{
   /* protected $connection = 'mongodb';*/
    protected $collection = 'sys.setting';
    
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
        '_id',          // string   setting id
        'name',         // string   setting name
        'format',       // string   setting value format: string, number, array, object, ...
        'value',        // string   setting value
        'store',        // string   setting store id
        'locales',      // array    setting locales
        'startup',      // int      setting start on boot
        'status',       // int      setting status 0=disable, 1=enable
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
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
        $guid = Arr::get($data, 'id');
        $setting = self::find($guid);

        if ($setting) {
            return $setting;
        }

        $setting = new Setting();
        $setting->_id = $guid;
        $setting->name = '';
        $setting->format = '';
        $setting->value = '';
        $setting->fill(Arr::only($data, $setting->getFillable()));
        $setting->save();

        return $setting;
    }
}