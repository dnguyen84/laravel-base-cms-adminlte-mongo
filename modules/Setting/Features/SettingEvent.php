<?php

namespace Modules\Setting\Features;

/**
 * Setting model event
 */
trait SettingEvent
{
    /**
     * Boot the setting event
     *
     * @return void
     */
    public static function bootSettingEvent() {
        static::saving(function ($model) {

            $model->name = trim($model->name);
            $model->format = trim($model->format);

            $model->store   = $model->store ?: [];
            $model->locales = $model->locales ?: object();
            $model->startup = boolval($model->startup ?? false);
            $model->status  = $model->status ?? 1;

            /**
             * Process setting value
             */
            try 
            {
                if ($model->format == 'number') {
                    $model->value = intval($model->value);
                }
        
                if ($model->format == 'json') {
                    $model->value = is_string($model->value) ? json_decode($model->value) : $model->value;
                }
            } catch(Exception $e) {
                $model->value = strval($model->value);
            }

            /**
             * Add setting audit
             */
            if (empty($model->created)) {
                $model->created = now();
            }

            $model->updated = now();
            $model->cast();
        });
    }
}