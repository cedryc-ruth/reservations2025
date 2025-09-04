<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret_key'));
    }

    /**
     * Créer une session de checkout Stripe
     */
    public function createCheckoutSession(array $lineItems, string $successUrl, string $cancelUrl, array $metadata = [])
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => $metadata,
                'customer_email' => auth()->user()->email ?? null,
            ]);

            return $session;
        } catch (ApiErrorException $e) {
            throw new \Exception('Erreur lors de la création de la session Stripe: ' . $e->getMessage());
        }
    }

    /**
     * Récupérer une session Stripe
     */
    public function retrieveSession(string $sessionId)
    {
        try {
            return Session::retrieve($sessionId);
        } catch (ApiErrorException $e) {
            throw new \Exception('Erreur lors de la récupération de la session Stripe: ' . $e->getMessage());
        }
    }

    /**
     * Formater les items pour Stripe
     */
    public function formatLineItems(array $tickets, string $showTitle)
    {
        $lineItems = [];

        foreach ($tickets as $ticket) {
            if ($ticket['quantity'] > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $showTitle,
                            'description' => ucfirst($ticket['type']) . ' - ' . $ticket['description'],
                        ],
                        'unit_amount' => $ticket['price'] * 100, // Stripe utilise les centimes
                    ],
                    'quantity' => $ticket['quantity'],
                ];
            }
        }

        return $lineItems;
    }
}
