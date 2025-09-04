@extends('layouts.app')

@section('title', 'Traitement du paiement')

@section('content')
<div class="inner">
    <header>
        <h1>💳 Traitement du paiement</h1>
        <p>Redirection vers Stripe en cours...</p>
    </header>

    <div class="payment-processing">
        <div class="loading-spinner">
            <div class="spinner"></div>
        </div>
        
        <div class="payment-info">
            <h3>Votre paiement est en cours de traitement</h3>
            <p>Vous allez être redirigé vers la page de paiement sécurisée de Stripe.</p>
            
            <div class="security-info">
                <h4>🔒 Sécurité garantie</h4>
                <ul>
                    <li>Paiement 100% sécurisé par Stripe</li>
                    <li>Aucune donnée bancaire stockée sur nos serveurs</li>
                    <li>Chiffrement SSL/TLS</li>
                    <li>Conformité PCI DSS</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.payment-processing {
    max-width: 600px;
    margin: 2rem auto;
    text-align: center;
    padding: 2rem;
    background: #f9f9f9;
    border-radius: 12px;
    border: 1px solid #ddd;
}

.loading-spinner {
    margin-bottom: 2rem;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #007cba;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.payment-info h3 {
    color: #333;
    margin-bottom: 1rem;
}

.payment-info p {
    color: #666;
    margin-bottom: 2rem;
}

.security-info {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    text-align: left;
}

.security-info h4 {
    color: #007cba;
    margin-bottom: 1rem;
    text-align: center;
}

.security-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.security-info li {
    padding: 0.5rem 0;
    color: #666;
    border-bottom: 1px solid #f0f0f0;
}

.security-info li:last-child {
    border-bottom: none;
}

.security-info li:before {
    content: "✓";
    color: #28a745;
    font-weight: bold;
    margin-right: 0.5rem;
}
</style>

<script>
// Redirection automatique après 3 secondes si nécessaire
setTimeout(function() {
    // Cette fonction peut être utilisée pour rediriger automatiquement
    // si la redirection Stripe ne fonctionne pas
}, 3000);
</script>
@endsection
