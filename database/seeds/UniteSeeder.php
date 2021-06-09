<?php

use Illuminate\Database\Seeder;
use App\Models\Unite;

class UniteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unite::create([
            'unite_fr' => 'Unite',
            'unite_ar' => 'وحدة'
        ],[
            'unite_fr' => 'Unite 1',
            'unite_ar' => 'وحدة 1'
        ]);
        Unite::create([
            'unite_fr' => 'Unite 2',
            'unite_ar' => 'وحدة 2'
        ]);
        Unite::create([
            'unite_fr' => 'Unite 3',
            'unite_ar' => 'وحدة 3'
        ]);
        Unite::create([
            'unite_fr' => 'Unite 4',
            'unite_ar' => 'وحدة 4'
        ]);
    }
}
