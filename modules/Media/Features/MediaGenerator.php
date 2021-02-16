<?php

namespace Modules\Media\Features;

class MediaGenerator
{
    /**
     * Media helper function to build url
     * @example MediaGenerator::url($url)
     * @example MediaGenerator::url($url, ['type' => 'thumb'])
     */
    public static function url($url, $extra = [])
    {
        # Get query string from {url}
        list($path, $query) = self::extract($url);

        # Parse query
        if ($query) {
            $params = parse_url($query);
            {
                parse_str($params['query'] ?? '', $params);
            }
            $extra = array_merge($params, $extra);
        }

        # Process extra data
        if ($extra) {
            $query  = '';
            $bucket = [];
            foreach ($extra as $key => $value) {
                $bucket[] = "{$key}={$value}";
            }
            $query = implode('&', $bucket);
        }

        # Handle external url, we use proxy to resize image
        if (strpos($url, 'http') === 0) {
            return config('media.server') . '/proxy?url=' . $path  . ($query ? '&' . $query : '');
        } else {
            return config('media.server') . '/' . trim($path, '/') . ($query ? '?' . $query : '');
        }
    }

    /**
     * Extract the query string from the given path.
     *
     * @param  string  $path
     * @return array
     */
    public static function extract($path)
    {
        if (($queryPosition = strpos($path, '?')) !== false) {
            return [
                substr($path, 0, $queryPosition),
                substr($path, $queryPosition),
            ];
        }

        return [$path, ''];
    }
}