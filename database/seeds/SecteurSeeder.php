<?php

use Illuminate\Database\Seeder;
use App\Models\Secteur;
use App\Models\Dr;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Secteur::create(['secteur_fr' => 'Secteur1', 'secteur_ar' => 'Secteur1']);
        Secteur::create(['secteur_fr' => 'Secteur2', 'secteur_ar' => 'Secteur2']);
        Secteur::create(['secteur_fr' => 'Secteur3', 'secteur_ar' => 'Secteur3']);
        
        
        // factory(App\Models\Secteur::class, 1000)->create()->each(function ($secteurs) {
        //     $secteurs->save(factory(App\Models\Secteur::class)->make());
        // });
    }

    
}
