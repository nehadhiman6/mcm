<?php

return [
    'app_location' => env('APP_LOCATION', 'client'),
    'college_name' => env('COLLEGE_NAME', ''),
    'college_name_short' => env('COLLEGE_NAME_SHORT', 'MCM'),
    'max_image_upload_size' => env('MAX_IMAGE_UPLOAD_SIZE', '50'),
    'max_file_upload_size' => env('MAX_FILE_UPLOAD_SIZE', '300'),
    'max_photo_upload_size' => env('MAX_PHOTO_UPLOAD_SIZE', '300'),
    'max_sign_upload_size' => env('MAX_SIGN_UPLOAD_SIZE', '300'),
    'nocaptcha_sitekey' => env('NOCAPTCHA_SITEKEY', ''),
    'alumni_meet_fee' => env('ALUMNI_MEET_FEE', 0),
    'payment_pros_fee' => env('PAYMENT_PROS_FEE', 900),
    'alumni_life_fee' => env('ALUMNI_LIFE_FEE', 0),
    'hostel_pros_fee' => env('HOSTEL_PROS_FEE', 850),
    'parking_fee' => env('PARKING_FEE', 0),
    'add_on_fee' => env('ADD_ON_FEE', 0),
    'foreign_fee' => env('FOREIGN_FEE', 0),
    'mig_fee' => env('MIG_FEE', 0),
    'parking_sh_id' => env('PARKING_SH_ID', 0),
    'addon_sh_id' => env('ADDON_SH_ID', 0),
    'foreign_sh_id' => env('FOREIGN_SH_ID', 0),
    'mig_sh_id' => env('MIG_SH_ID', 0),
    'atom' => [
        'mode' => env('ATOM_MODE', 'test'),
        'login' => env('ATOM_LOGIN', ''),
        'pass' => env('ATOM_PASS', ''),
        'prodid' => env('ATOM_PRODID', ''),
        'client_code' => env('ATOM_CLIENT_CODE'),
        'req_hash_key' => env('REQ_HASH_KEY'),
        'res_hash_key' => env('RES_HASH_KEY'),
        'trnurl' => env('ATOM_TRNURL', ''),
        'qryurl' => env('ATOM_QRYURL', ''),
    ],
    'payu' => [
        'key' => env('PAYU_KEY'),
        'salt' => env('PAYU_SALT'),
        'trnurl' => env('PAYU_TRNURL'),
        'qryurl' => env('PAYU_QRYURL'),
        'auth_header' => env('PAYU_AUTH_HEADER'),
    ],
    'paytm1' => [
        'mid' => env('PAYTM_MID'),
        'key' => env('PAYTM_MERCHANT_KEY'),
        'trnurl' => env('PAYTM_TRNURL'),
        'qryurl' => env('PAYTM_QRYURL')
    ],
    'payment_trn_wait' => env('PAYMENT_TRN_WAIT', 10),
];