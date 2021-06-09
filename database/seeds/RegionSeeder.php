<?php

use App\Models\Dpci;
use Illuminate\Database\Seeder;
use App\Models\Dr;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dr::create(['region_fr' => 'Tanger-Tétouan-Al Hoceïma', 'region_ar' => 'طنجة تطوان الحسيمة']);
        Dr::create(['region_fr' => 'L\'Oriental', 'region_ar' => 'الشرق']);
        Dr::create(['region_fr' => 'Fès-Meknès', 'region_ar' => 'فاس مكناس']);
        Dr::create(['region_fr' => 'Rabat-Salé-Kénitra', 'region_ar' => 'الرباط سلا القنيطرة']);
        Dr::create(['region_fr' => 'Béni Mellal-Khénifra', 'region_ar' => 'بني ملال خنيفرة']);
        Dr::create(['region_fr' => 'Casablanca-Settat', 'region_ar' => 'الدار البيضاء سطات']);
        Dr::create(['region_fr' => 'Marrakech-Safi', 'region_ar' => 'مراكش آسفي']);
        Dr::create(['region_fr' => 'Drâa-Tafilalet', 'region_ar' => 'درعة تافيلالت']);
        Dr::create(['region_fr' => 'Souss-Massa', 'region_ar' => 'سوس ماسة']);
        Dr::create(['region_fr' => 'Guelmim-Oued Noun', 'region_ar' => 'كلميم واد نون']);
        Dr::create(['region_fr' => 'Laâyoune-Sakia El Hamra', 'region_ar' => 'العيون الساقية الحمراء']);
        Dr::create(['region_fr' => 'Dakhla-Oued Ed-Dahab', 'region_ar' => 'الداخلة وادي الذهب']);

        Dpci::create(['domaine_fr'=>'Tanger', 'domaine_ar'=>'طنجة', 'type'=>'P','dr_id' => 1]);
        Dpci::create(['domaine_fr'=>'Khénifra', 'domaine_ar'=>'خنيفرة', 'type'=>'P','dr_id' => 5]);
        Dpci::create(['domaine_fr'=>'Meknès', 'domaine_ar'=>'مكناس', 'type'=>'P','dr_id' => 3]);
        Dpci::create(['domaine_fr'=>'Rabat', 'domaine_ar'=>'الرباط', 'type'=>'R','dr_id' => 4]);

    }
}
