<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY', 'SB-Mid-server-J93eEx4Qd4Tymv3oO1eCea7y'), // Sandbox fallback
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-J3aZ1b2c3d4e5f6g'), // Sandbox fallback
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),
];
