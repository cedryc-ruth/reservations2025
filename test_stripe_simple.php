<?php

require_once 'vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

echo "=== Test Stripe Simple ===\n";

try {
    // Charger la configuration Laravel
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    echo "✅ Laravel chargé\n";
    
    // Configuration Stripe
    $secretKey = config('stripe.secret_key');
    echo "Clé secrète: " . substr($secretKey, 0, 20) . "...\n";
    
    Stripe::setApiKey($secretKey);
    echo "✅ Configuration Stripe appliquée\n";
    
    // Créer une session de test
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Test Product',
                ],
                'unit_amount' => 1000, // 10€
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://example.com/success',
        'cancel_url' => 'https://example.com/cancel',
    ]);
    
    echo "✅ Session créée avec succès\n";
    echo "ID: " . $session->id . "\n";
    echo "URL: " . $session->url . "\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Type: " . get_class($e) . "\n";
}

echo "=== Fin ===\n";
