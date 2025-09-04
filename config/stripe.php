<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour l'intégration Stripe
    |
    */

    'public_key' => env('STRIPE_KEY', 'pk_test_your_stripe_public_key_here'),
    'secret_key' => env('STRIPE_SECRET', 'sk_test_your_stripe_secret_key_here'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', 'whsec_your_webhook_secret_here'),
    
    'currency' => 'eur',
    'country' => 'FR',
];
