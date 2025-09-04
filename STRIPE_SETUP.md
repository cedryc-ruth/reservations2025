# Configuration Stripe pour Reservations 2025

## 🔑 Configuration des clés API

### 1. Créer un compte Stripe
- Allez sur [https://stripe.com](https://stripe.com)
- Créez un compte développeur
- Accédez au tableau de bord Stripe

### 2. Récupérer les clés API
- Dans le tableau de bord Stripe, allez dans "Développeurs" > "Clés API"
- Copiez votre **Clé publique** (commence par `pk_test_`)
- Copiez votre **Clé secrète** (commence par `sk_test_`)

### 3. Configurer les variables d'environnement
Ajoutez ces lignes à votre fichier `.env` :

```env
# Stripe Configuration
STRIPE_KEY=pk_test_votre_cle_publique_ici
STRIPE_SECRET=sk_test_votre_cle_secrete_ici
STRIPE_WEBHOOK_SECRET=whsec_votre_webhook_secret_ici
```

### 4. Configuration des webhooks (optionnel)
- Dans le tableau de bord Stripe, allez dans "Développeurs" > "Webhooks"
- Créez un nouveau webhook avec l'URL : `https://votre-domaine.com/payment/webhook`
- Sélectionnez les événements : `checkout.session.completed`, `payment_intent.succeeded`
- Copiez le secret du webhook

## 🧪 Mode test

### Cartes de test Stripe
Utilisez ces cartes pour tester :

**Paiement réussi :**
- Numéro : `4242 4242 4242 4242`
- Date : n'importe quelle date future
- CVC : n'importe quel code à 3 chiffres

**Paiement échoué :**
- Numéro : `4000 0000 0000 0002`
- Date : n'importe quelle date future
- CVC : n'importe quel code à 3 chiffres

## 🚀 Utilisation

1. **Accéder à un spectacle** : `/shows/{id}`
2. **Cliquer sur "Réserver maintenant"**
3. **Choisir la date et les tickets**
4. **Cliquer sur "💳 Payer avec Stripe"**
5. **Être redirigé vers Stripe Checkout**
6. **Effectuer le paiement**
7. **Être redirigé vers la confirmation**

## 📁 Fichiers créés

- `app/Services/StripeService.php` - Service pour Stripe
- `app/Http/Controllers/PaymentController.php` - Contrôleur de paiement
- `config/stripe.php` - Configuration Stripe
- `resources/views/payment/processing.blade.php` - Vue de traitement

## 🔧 Routes ajoutées

- `POST /payment/create` - Créer une session de paiement
- `GET /payment/success/{reservation}` - Succès du paiement
- `GET /payment/cancel/{reservation}` - Annulation du paiement
- `POST /payment/webhook` - Webhook Stripe

## ⚠️ Notes importantes

- **Mode test** : Utilisez les clés de test pour le développement
- **Mode production** : Remplacez par les clés de production
- **Sécurité** : Ne jamais exposer les clés secrètes
- **Webhooks** : Configurez les webhooks pour la production
