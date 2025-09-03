# Fonctionnalité de Paiement - Système de Tickets

## Vue d'ensemble

Cette fonctionnalité permet aux utilisateurs d'acheter des tickets pour les spectacles disponibles dans le système. Elle inclut un processus complet d'achat, de paiement et de gestion des tickets.

## Fonctionnalités

### 1. Achat de Tickets
- **Sélection du spectacle** : L'utilisateur choisit un spectacle depuis le catalogue
- **Sélection de la représentation** : Choix de la date et heure de la représentation
- **Sélection du tarif** : Choix entre différents types de tarifs (normal, réduit, etc.)
- **Quantité** : Sélection du nombre de tickets (1 à 10 maximum)
- **Calcul automatique** : Le prix total est calculé en temps réel

### 2. Processus de Paiement
- **Méthodes de paiement** :
  - Carte bancaire
  - PayPal
  - Virement bancaire
- **Sécurité** : Simulation de paiement sécurisé SSL
- **Confirmation** : Génération d'une référence de paiement unique

### 3. Gestion des Tickets
- **Statuts** :
  - `pending` : En attente de paiement
  - `paid` : Payé et confirmé
  - `cancelled` : Annulé
  - `used` : Utilisé
- **Actions disponibles** :
  - Voir les détails
  - Procéder au paiement (si en attente)
  - Annuler le ticket (si en attente ou payé)

## Structure Technique

### Modèles
- **Ticket** : Gère les tickets achetés avec tous les détails

### Contrôleurs
- **TicketController** : Gère toute la logique métier des tickets

### Vues
- `tickets/purchase.blade.php` : Formulaire d'achat
- `tickets/payment.blade.php` : Page de paiement
- `tickets/show.blade.php` : Détails d'un ticket
- `tickets/index.blade.php` : Liste des tickets de l'utilisateur

### Routes
```php
// Achat et gestion des tickets
Route::middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{id}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
});

Route::get('/shows/{id}/buy-tickets', [TicketController::class, 'showPurchaseForm'])->name('tickets.purchase.form');
Route::post('/tickets/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
Route::get('/tickets/{id}/payment', [TicketController::class, 'showPayment'])->name('tickets.payment');
Route::post('/tickets/{id}/payment', [TicketController::class, 'processPayment'])->name('tickets.payment.process');
```

## Installation et Configuration

### 1. Migration
Exécutez la migration pour créer la table `tickets` :
```bash
php artisan migrate
```

### 2. Seeder (Optionnel)
Pour tester avec des données d'exemple :
```bash
php artisan db:seed --class=TicketSeeder
```

### 3. Vérification
- Vérifiez que les routes sont accessibles
- Testez l'achat d'un ticket
- Vérifiez la gestion des statuts

## Utilisation

### Pour l'utilisateur final
1. **Parcourir les spectacles** : Aller sur `/shows`
2. **Choisir un spectacle** : Cliquer sur un spectacle
3. **Acheter des tickets** : Cliquer sur "Acheter des tickets"
4. **Sélectionner les options** : Date, tarif, quantité
5. **Procéder au paiement** : Choisir la méthode de paiement
6. **Confirmation** : Recevoir la confirmation et les détails

### Pour l'administrateur
- **Gestion des tickets** : Via l'interface Filament (à implémenter)
- **Suivi des ventes** : Consultation des tickets vendus
- **Gestion des annulations** : Traitement des demandes d'annulation

## Sécurité

### Authentification
- Toutes les actions de gestion des tickets nécessitent une authentification
- Vérification que l'utilisateur ne peut accéder qu'à ses propres tickets

### Validation
- Validation des données d'entrée
- Vérification des permissions
- Protection CSRF sur tous les formulaires

### Paiement
- Simulation sécurisée du processus de paiement
- Génération de références uniques
- Traçabilité complète des transactions

## Évolutions Futures

### Intégrations de Paiement
- **Stripe** : Paiement par carte bancaire
- **PayPal** : Paiement en ligne
- **Virement SEPA** : Paiement par virement

### Fonctionnalités Avancées
- **Réservation de sièges** : Sélection précise des places
- **Billets électroniques** : Génération de QR codes
- **Notifications** : Emails de confirmation et rappels
- **Remboursements** : Gestion des demandes de remboursement
- **Groupes** : Réservations pour des groupes

### Administration
- **Interface Filament** : Gestion complète des tickets
- **Rapports** : Statistiques de vente et d'occupation
- **Export** : Données pour la comptabilité

## Support et Maintenance

### Logs
- Toutes les actions sont loggées
- Traçabilité complète des transactions
- Gestion des erreurs avec messages utilisateur

### Tests
- Tests unitaires pour la logique métier
- Tests d'intégration pour les processus complets
- Tests de sécurité pour les permissions

## Notes Techniques

### Base de données
- Table `tickets` avec relations vers `users`, `representations` et `prices`
- Index sur les colonnes fréquemment consultées
- Contraintes de clés étrangères pour l'intégrité

### Performance
- Pagination des listes de tickets
- Chargement optimisé des relations
- Cache des données fréquemment consultées

### Compatibilité
- Compatible avec Laravel 10+
- Interface responsive pour mobile et desktop
- Support des navigateurs modernes
