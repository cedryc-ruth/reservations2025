# Configuration Stripe pour le Système de Paiement

## Prérequis

1. **Compte Stripe** : Créez un compte sur [stripe.com](https://stripe.com)
2. **Clés API** : Récupérez vos clés API depuis le dashboard Stripe

## Configuration

### 1. Variables d'environnement

Ajoutez ces variables dans votre fichier `.env` :

```env
# Stripe Configuration
STRIPE_PUBLISHABLE_KEY=pk_test_votre_cle_publique
STRIPE_SECRET_KEY=sk_test_votre_cle_secrete
STRIPE_WEBHOOK_SECRET=whsec_votre_webhook_secret

# URLs de redirection (optionnel)
STRIPE_SUCCESS_URL=/tickets/{id}/success
STRIPE_CANCEL_URL=/tickets/{id}/stripe-cancel
```

### 2. Clés de test Stripe

Pour les tests, utilisez ces cartes de test :

- **Visa** : `4242 4242 4242 4242`
- **Mastercard** : `5555 5555 5555 4444`
- **Date d'expiration** : N'importe quelle date future
- **CVC** : N'importe quels 3 chiffres
- **Code postal** : N'importe quoi

### 3. Configuration en production

En production, remplacez les clés de test par les clés live :

```env
STRIPE_PUBLISHABLE_KEY=pk_live_votre_cle_publique
STRIPE_SECRET_KEY=sk_live_votre_cle_secrete
```

## Test de la fonctionnalité

### 1. Démarrer le serveur
```bash
php artisan serve
```

### 2. Tester l'achat
1. Allez sur `/shows`
2. Cliquez sur un spectacle
3. Cliquez sur "Acheter des tickets"
4. Remplissez le formulaire
5. Vous serez redirigé vers Stripe Checkout
6. Utilisez une carte de test
7. Confirmez le paiement

### 3. Vérifier la confirmation
- Vous devriez être redirigé vers la page de succès
- Le ticket doit avoir le statut "paid"
- La référence de paiement doit être enregistrée

## Webhooks (Optionnel)

Pour une gestion complète des paiements, configurez les webhooks Stripe :

### 1. Dans le dashboard Stripe
- Allez dans "Developers" > "Webhooks"
- Créez un endpoint : `https://votre-site.com/stripe/webhook`
- Sélectionnez les événements :
  - `checkout.session.completed`
  - `payment_intent.succeeded`
  - `payment_intent.payment_failed`

### 2. Webhook Secret
- Copiez le webhook secret dans votre `.env`
- Utilisez-le pour vérifier les webhooks

## Sécurité

### 1. Clés secrètes
- **NE JAMAIS** commiter vos clés secrètes dans Git
- Utilisez toujours des variables d'environnement
- En production, utilisez des clés live

### 2. Validation
- Vérifiez toujours les webhooks
- Validez les montants côté serveur
- Utilisez HTTPS en production

### 3. Test
- Testez toujours en mode test d'abord
- Utilisez les cartes de test Stripe
- Vérifiez tous les scénarios (succès, échec, annulation)

## Dépannage

### Erreur "Invalid API key"
- Vérifiez que `STRIPE_SECRET_KEY` est correcte
- Assurez-vous qu'il n'y a pas d'espaces

### Erreur "No such payment_intent"
- Vérifiez que la session Stripe est valide
- Vérifiez les URLs de redirection

### Page de succès ne s'affiche pas
- Vérifiez les routes dans `web.php`
- Vérifiez que la vue `tickets.success` existe

## Support

- **Documentation Stripe** : [stripe.com/docs](https://stripe.com/docs)
- **Support Stripe** : [support.stripe.com](https://support.stripe.com)
- **Laravel Stripe** : [github.com/stripe/stripe-php](https://github.com/stripe/stripe-php)
