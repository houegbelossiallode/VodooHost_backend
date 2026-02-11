<?php

namespace Database\Seeders;

use App\Models\Avis;
use App\Models\Logement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AvisTableSeeder extends Seeder
{
    public function run()
    {
        // Récupérer des utilisateurs et logements existants
        $users = User::take(5)->get();
        $logements = Logement::take(10)->get();

        // Vérifier s'il y a des utilisateurs et des logements
        if ($users->isEmpty() || $logements->isEmpty()) {
            $this->command->info('Veuillez d\'abord créer des utilisateurs et des logements.');
            return;
        }

        // Créer des avis pour chaque logement
        foreach ($logements as $logement) {
            foreach ($users as $user) {
                Avis::create([
                    'user_id' => $user->id,
                    'logement_id' => $logement->id,
                    'notes' => rand(3, 5), // Note entre 3 et 5 étoiles
                    'commentaire' => $this->getRandomCommentaire(),
                ]);
            }
        }

        $this->command->info('Seeders pour les avis créés avec succès !');
    }

    private function getRandomCommentaire()
    {
        $commentaires = [
            'Séjour exceptionnel, je recommande vivement ce logement !',
            'Très bon accueil, logement conforme aux photos.',
            'Parfait pour un séjour en famille, nous reviendrons avec plaisir.',
            'Cadre magnifique et logement très confortable.',
            'Hôte très attentionné, je recommande les yeux fermés.'
        ];

        return $commentaires[array_rand($commentaires)];
    }
}