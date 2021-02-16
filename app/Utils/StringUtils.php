<?php


namespace App\Utils;


class StringUtils {
    /**
     * Generate random charactor.
     *
     * @param unknown_type $length
     */
    public static function generateRandom( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size  = strlen( $chars );
        $str   = "";
        for ( $i = 0; $i < $length; $i ++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }

    /**
     * Generates an UUID.
     *
     * @param
     *            string an optional prefix
     *
     * @return string the formatted uuid
     */
    public static function uuid( $prefix = '' ) {
        $chars = md5( uniqid( mt_rand(), true ) );
        $uuid  = substr( $chars, 0, 8 ) . '-';
        $uuid  .= substr( $chars, 8, 4 ) . '-';
        $uuid  .= substr( $chars, 12, 4 ) . '-';
        $uuid  .= substr( $chars, 16, 4 ) . '-';
        $uuid  .= substr( $chars, 20, 12 );

        return $prefix . $uuid;
    }

    /**
     * Check start with.
     * Enter description here ...
     *
     * @param unknown_type $haystack
     * @param unknown_type $needle
     * @return boolean
     */
    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Check end with Enter description here .
     * ..
     *
     * @param unknown_type $haystack
     * @param unknown_type $needle
     * @return boolean
     */
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
