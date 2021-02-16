<?php

namespace Modules\Backend\Features\User;

class UserStatus
{
    const DELETED   = -2;
    const BLOCKED   = -1;
    const INACTIVE  = 0;
    const ACTIVE    = 1;

    private static $status = [
        -2 => 'Deleted',
        -1 => 'Blocked',
        0  => 'Disable',
        1  => 'Active',
    ];

    private static $colors = [
        -2 => 'danger',
        -1 => 'danger',
        0  => 'warning',
        1  => 'success',
    ];

    /**
     * Get {status} name
     * @example OrderStatus::getName(10)
     * @example OrderStatus::getName($order->status)
     */
    public static function getName($status = null)
    {
        if ($status !== null) {
            return self::$status[$status] ?? 'N/A';    
        }
        return self::$status;
    }

    /**
     * Get {status} color
     * @example OrderStatus::getColor(10)
     * @example OrderStatus::getColor($order->status)
     */
    public static function getColor($status = null)
    {
        if ($status !== null) {
            return self::$colors[$status] ?? 'default';    
        }
        return self::$colors;
    }
}