<?php


namespace App\Utils;


class APUtils {

    /**
     * convertArrayToObject
     *
     * @param type $array_input
     *
     * @return \stdClass
     */
    public static function convertArrayToObject( $array_input ) {
        $result = new stdClass();
        foreach ( $array_input as $key => $value ) {
            $result->$key = $value;
        }

        return $result;
    }


    /**
     * convertObjectToArray
     *
     * @param type $object
     *
     * @return type
     */
    public static function convertObjectToArray( $object ) {
        if ( ! is_object( $object ) && ! is_array( $object ) ) {
            return $object;
        }
        if ( is_object( $object ) ) {
            $object = get_object_vars( $object );
        }

        return $object;
    }
}
