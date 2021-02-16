<?php

/*
|--------------------------------------------------------------------------
| Core collection helper class, we extend collection method here
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

/**
 * Register collection macro
 * @example $collection->toUpper();
 * @example $collection->toString();
 * @example $collection->toNumber();
 */
Collection::macro('toUpper', function () {
    return $this->map(function ($value) {
        return Str::upper($value);
    });
});

Collection::macro('toString', function () {
    return $this->map(function ($value) {
        return strval($value);
    });
});

Collection::macro('toNumber', function () {
    return $this->map(function ($value) {
        return intval($value);
    });
});

/**
 * Remove empty or null value from list array
 */
Collection::macro('clean', function () {
    return $this->map(function($item, $key) {
        if (is_string($item)) {
            return trim($item);
        } else {
            return $item;
        }
    })->reject(function($item) {
        return empty($item);
    });
});