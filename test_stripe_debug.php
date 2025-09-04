<?php

require_once 'vendor/autoload.php';

echo "=== Test Stripe ===\n";

// Test des classes
if (class_exists('Stripe\Stripe')) {
    echo "✅ Stripe trouvé\n";
} else {
    echo "❌ Stripe NON trouvé\n";
}

// Test de la config
$config = include 'config/stripe.php';
echo "Config chargée: " . (is_array($config) ? "✅" : "❌") . "\n";

// Test des clés
if (isset($config['secret_key']) && strlen($config['secret_key']) > 10) {
    echo "✅ Clé secrète configurée\n";
} else {
    echo "❌ Clé secrète manquante\n";
}

echo "=== Fin ===\n";
