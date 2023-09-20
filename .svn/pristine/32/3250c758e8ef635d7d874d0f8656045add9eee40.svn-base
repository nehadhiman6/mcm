<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paytm' => [
        'mid' => env('PAYTM_MID'),
        'merchant_key' => env('PAYTM_MERCHANT_KEY'),
        'ind_type_id' => env('PAYTM_IND_TYPE_ID'),
        'website' => env('PAYTM_WEBSITE'),
        'trnurl' => env('PAYTM_TRNURL'),
        'qryurl' => env('PAYTM_QRYURL'),
    ],

    'atom' => [
        'login' => env('ATOM_LOGIN'),
        'pass' => env('ATOM_PASS'),
        'prodid' => env('ATOM_PRODID'),
        'client_code' => env('ATOM_CLIENT_CODE'),
        'req_hash_key' => env('REQ_HASH_KEY'),
        'res_hash_key' => env('RES_HASH_KEY'),
        'trnurl' => env('ATOM_TRNURL'),
        'qryurl' => env('ATOM_QRYURL'),
    ],

    'easyway' => [
        'api_key' => env('SMS_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID')
    ],

    'sbipay' => [
        "mer_id" => env('SBI_PAY_MER_ID'),
        "mer_key" => env('SBI_PAY_MER_KEY'),
        "trn_url" => env('SBI_PAY_TRN_URL'),
        "qryurl" => env('SBI_PAY_QRYURL'),
    ]

];
