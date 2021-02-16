<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Payment debug mode
    |--------------------------------------------------------------------------
    |
    | This option determines logging payment information to logging file
    |
    */

    'debug' => env('PAYMENT_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Payment product count limit
    |--------------------------------------------------------------------------
    |
    | How many product can add to cart and bookcase
    |
    */

    'limit' => env('PAYMENT_LIMIT', 2),

    /*
    |--------------------------------------------------------------------------
    | Payment allow method
    |--------------------------------------------------------------------------
    */

    'method' => env('PAYMENT_METHOD', 'vnpay'),

    /*
    |--------------------------------------------------------------------------
    | Payment allow object
    | - Pay for fundme donate
    | - Pay for order
    | - Pay for wallet
    |--------------------------------------------------------------------------
    */

    'source' => env('PAYMENT_SOURCE', 'fundme,order,wallet'),

    /*
    |--------------------------------------------------------------------------
    | Order donation percent
    |--------------------------------------------------------------------------
    */

    'donation' => intval(env('PAYMENT_DONATION', 50)),

    /*
    |--------------------------------------------------------------------------
    | Service list config
    |--------------------------------------------------------------------------
    */

    /**
     * VNPAY is default payment method
     */
    'vnpay' => [
        'kind' => env('VNP_TYPE_BOOK', 0),
        'return' => env('VNP_RETURN', 'http://localhost:8080/payment/return'),
        'allows' => env('VNP_ALLOW_IP', '127.0.0.1'),
        'url_pay' => env('VNP_URL_PAY', 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
        'url_query' => env('VNP_URL_QUERY', 'http://sandbox.vnpayment.vn/merchant_webapi/merchant.html'),
        'url_refund' => env('VNP_URL_REFUND', 'http://sandbox.vnpayment.vn/merchant_webapi/merchant.html'),
        'order' => [
            'code' => env('VNP_ORDER_CODE', 'XXX'),
            'secret' => env('VNP_ORDER_HASHSECRET', 'XXX'),
        ],
        'donate' => [
            'code' => env('VNP_DONATE_CODE', 'XXX'),
            'secret' => env('VNP_DONATE_HASHSECRET', 'XXX'),
        ],
        'wallet' => [
            'code' => env('VNP_WALLET_CODE', 'XXX'),
            'secret' => env('VNP_WALLET_HASHSECRET', 'XXX'),
        ],
        'payment' => [
            'code' => env('VNP_DEFAULT_CODE', 'XXX'),
            'secret' => env('VNP_DEFAULT_HASHSECRET', 'XXX'),
        ],
    ],
    
    /**
     * Viettel Pay will add later
     */
    'viettel' => [

    ],
];
