<?php

namespace Modules\Core\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Parser
{
    /**
     * Create searchable from text
     * @example Parse::parseNumber($number)
     */
    public static function searchable($text)
    {
        $text = Str::slug($text, ' ');
        $text = strtolower($text);
        return $text;
    }

    /**
     * Parse a number from text
     * @example Parse::parseNumber($number)
     */
    public static function parseNumber($input)
    {
        if ($input !== null) {
            $input = (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        }
        return $input;
    }

    /**
     * Parse a text
     * @example Parse::parseText($text)
     */
    public static function parseText($input)
    {
        if ($input !== null) {
            $input = strip_tags(trim($input));
        }
        return $input;
    }

    /**
     * Parse a array from text
     * @example Parse::parseArray('1,2', ',')
     */
    public static function parseArray($input, $sep = ',')
    {
        $text = self::parseText($input);
        $list = explode($sep, $text);
        $collection = collect($list)->map(function($item, $key) {
            return trim($item);
        })->reject(function($item) {
            return empty($item);
        });
        return $collection->unique()->values()->all() ?? [];
    }

    /**
     * Parse year from string
     * @example Parser::parseYear('2015-2019') -> [2015, 2019]
     */
    public static function parsePair($input, $sep = '-')
    {
        $bucket = self::parseArray($input, $sep);

        $start = '';
        $end = '';

        if (count($bucket) == 2) {
            list($start, $end) = $bucket;
        }

        $pair = [
            'start' => $start,
            'end' => $end,
        ];

        return $pair;
    }
}