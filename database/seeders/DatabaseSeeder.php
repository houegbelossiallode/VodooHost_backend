<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Désactiver temporairement les contraintes de clé étrangère
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // // Appel des seeders
        // $this->call([
        //     // ... autres seeders
        //     AvisTableSeeder::class,
        // ]);
        
        // // Réactiver les contraintes
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(TemoignageSeeder::class);
    }
}
