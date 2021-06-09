<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(SecteurSeeder::class);
        // $this->call(RegionSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(UniteSeeder::class);
        $this->call(PermissionTableSeeder::class);
    }
}
