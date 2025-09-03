<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Representation;
use App\Models\Price;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer quelques utilisateurs, représentations et prix
        $users = User::take(3)->get();
        $representations = Representation::take(5)->get();
        $prices = Price::take(3)->get();

        if ($users->isEmpty() || $representations->isEmpty() || $prices->isEmpty()) {
            $this->command->info('Impossible de créer des tickets : données insuffisantes');
            return;
        }

        // Créer quelques tickets d'exemple
        $statuses = ['pending', 'paid', 'cancelled'];
        $paymentMethods = ['card', 'paypal', 'transfer'];

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $representation = $representations->random();
            $price = $prices->random();
            $quantity = rand(1, 4);
            $status = $statuses[array_rand($statuses)];
            
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'representation_id' => $representation->id,
                'price_id' => $price->id,
                'quantity' => $quantity,
                'total_price' => $price->price * $quantity,
                'status' => $status,
                'payment_method' => $status === 'paid' ? $paymentMethods[array_rand($paymentMethods)] : null,
                'payment_reference' => $status === 'paid' ? 'PAY-' . strtoupper(uniqid()) : null,
                'purchased_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('Tickets créés avec succès !');
    }
}
