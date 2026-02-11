<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Temoignage;

class TemoignageSeeder extends Seeder
{
    public function run(): void
    {
        $temoignages = [
            [
                'user_id' => 10,
                'note' => 5,
                'message' => "Une immersion incroyable dans la culture vodoun ! L’accueil de mon hôte était chaleureux et authentique. Les cérémonies et les danses traditionnelles m’ont profondément marqué.",
            ],
            [
                'user_id' => 11,
                'note' => 4,
                'message' => "J’ai adoré mon séjour. Le logement était propre et proche des lieux sacrés. Les guides locaux m’ont expliqué les rites avec beaucoup de respect. Une expérience unique.",
            ],
            [
                'user_id' => 11,
                'note' => 5,
                'message' => "Participer à un rituel Zangbéto m’a donné des frissons. C’était impressionnant ! Merci à Vodoun Hoost pour cette découverte hors du commun.",
            ],
            [
                'user_id' => 12,
                'note' => 4,
                'message' => "Très belle expérience culturelle. Les hôtes sont disponibles et le cadre paisible. J’ai appris énormément sur les traditions béninoises.",
            ],
            [
                'user_id' => 13,
                'note' => 5,
                'message' => "J’ai assisté à une cérémonie Egungun, c'était magique. Je recommande à tous ceux qui cherchent à vivre quelque chose d'authentique.",
            ],
            [
                'user_id' => 13,
                'note' => 3,
                'message' => "Séjour agréable, hôte sympathique. Quelques améliorations possibles dans l’organisation, mais globalement très satisfait de l’expérience.",
            ],
        ];

        foreach ($temoignages as $t) {
            Temoignage::create($t);
        }
    }
}
