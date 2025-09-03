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

    'publishable_key' => env('STRIPE_PUBLISHABLE_KEY', 'pk_test_...'),
    'secret_key' => env('STRIPE_SECRET_KEY', 'sk_test_...'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', 'whsec_...'),

    /*
    |--------------------------------------------------------------------------
    | Configuration par défaut
    |--------------------------------------------------------------------------
    */

    'currency' => 'eur',
    'locale' => 'fr',
    'payment_method_types' => ['card'],

    /*
    |--------------------------------------------------------------------------
    | URLs de redirection
    |--------------------------------------------------------------------------
    */

    'success_url' => env('STRIPE_SUCCESS_URL', '/tickets/{id}/success'),
    'cancel_url' => env('STRIPE_CANCEL_URL', '/tickets/{id}/stripe-cancel'),

    /*
    |--------------------------------------------------------------------------
    | Configuration des produits
    |--------------------------------------------------------------------------
    */

    'product_name_prefix' => 'Ticket - ',
    'product_description_suffix' => ' - Spectacle',

    /*
    |--------------------------------------------------------------------------
    | Configuration des webhooks
    |--------------------------------------------------------------------------
    */

    'webhook_events' => [
        'payment_intent.succeeded',
        'payment_intent.payment_failed',
        'checkout.session.completed',
        'checkout.session.expired',
    ],
];
