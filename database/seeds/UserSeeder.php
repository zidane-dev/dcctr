<?php

use Illuminate\Database\Seeder;
use \App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
// Role::findByName('dcsasd');
// Role::findByName('management');
// Role::findByName('mlm');
// Role::findByName('ss');
// Role::findByName('d-r');
// Role::findByName('d-p');
// Role::findByName('cs');
// Role::findByName('point focal');

        //USERS 1

        $user = User::create([
            'name' => 'Abdellatif',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 1,
            // 'status' => 1,
            // 'image' => ''
        ]);

        // $permissions = Permission::pluck('id','id')->all();
        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
        // ////////////////////////
        
        $user = User::create([
            'name' => 'Abdelhamid El Kabir',
            'email' => 'directeur-r@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 1,
            // 'status' => 1,
            // 'image' => ''
        ]);


        // $user->assignRole([$role->id]);
        // ////////////////////////

        $user = User::create([
            'name' => 'Abdelhamid EsSghir',
            'email' => 'directeur-p@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 2,
            // 'status' => 1,
            // 'image' => ''
        ]);


        // $user->assignRole([$role->id]);
        // ////////////////////////

        $user = User::create([
            'name' => 'Abdellah Ali',
            'email' => 'chef@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 2,
            // 'status' => 1,
            // 'image' => ''
        ]);

        $user = User::create([
            'name' => 'Abdellah Ali',
            'email' => 'chef-r@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 1,
            // 'status' => 1,
            // 'image' => ''
        ]);


        // $user->assignRole([$role->id]);
        // ////////////////////////


        // $role = Role::create(['name' => 'ss']);

        // $user->assignRole([$role->id]);
        // ////////////////////////

        $user = User::create([
            'name' => 'Emilem',
            'email' => 'emilem@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 39,
            // 'status' => 1,
            // 'image' => ''
        ]);


        // $user->assignRole([$role->id]);
        
        // ////////////////////////
        
        $user = User::create([
            'name' => 'Med',
            'email' => 'top@gmail.com',
            'password' => bcrypt('12345678'),
            'domaine_id' => 39,
            // 'status' => 1,
            // 'image' => ''
            ]);
            
        //     $role = Role::create(['name' => 'management']);
            
        // $user->assignRole([$role->id]);
        
        // ////////////////////////
        
        $user = User::create([
            'name' => 'Test',
            'email' => 'employe@gmail.fr',
            'password' => bcrypt('12345678'),
            'domaine_id' => 1,
            // 'status' => 1,
            // 'image' => ''
        ]);
        
        
        // $user->assignRole([$role->id]);
        // ////////////////////////
        
        $user = User::create([
            'name' => 'Abid',
            'email' => 'dcsasd@gmail.fr',
            'password' => bcrypt('12345678'),
            'domaine_id' => 39,
            // 'status' => 1,
            // 'image' => ''
        ]);
        
        
        // $user->assignRole([$role->id]);

        // USERS 2

        $user = User::create([
            'name' => 'Mr 1',
            'email' => 'dcsasd-cs@gmail.fr',
            'password' => bcrypt('12345678'),
            'domaine_id' => 39,
            // 'status' => 1,
            // 'image' => ''
        ]);
        
        
        // $user->assignRole([$role->id]);

        $user = User::create([
            'name' => 'Mr 2',
            'email' => 'dcsasd-cd@gmail.fr',
            'password' => bcrypt('12345678'),
            'domaine_id' => 39,
            // 'status' => 1,
            // 'image' => ''
        ]);
        
        
        // $user->assignRole([$role->id]);
        
        
    }
}
