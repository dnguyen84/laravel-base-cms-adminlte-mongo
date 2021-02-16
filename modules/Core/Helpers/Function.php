<?php

/*
|--------------------------------------------------------------------------
| Core helper functions
|--------------------------------------------------------------------------
*/

use Illuminate\Support\Str;

/**
 * Create empty object
 * @example $node->stats = object();
 */
function object()
{
    return new stdClass();
}

function slug($text, $sep = ' ') {
    return Str::slug($text, $sep);
}