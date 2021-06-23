<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Contracts\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission::create(['name_fr' =>'dashboard' , 'name_ar' => 'الرئيسية']);

        // Permission::create(['name_fr' =>'Liste des secteurs' , 'name_ar' => 'قائمة القطاعات']);
        // Permission::create(['name_fr' =>'Liste des indicateurs' , 'name_ar' => 'قائمة المؤشرات']);
        // Permission::create(['name_fr' =>'Liste resource Humaines' , 'name_ar' => 'قائمة الموارد البشرية']);

        // Permission::create(['name_fr' =>'Liste utilisateurs' , 'name_ar' => 'قائمة المستخدمين']);
        // Permission::create(['name_fr' =>'Liste rôles Utilisateurs' , 'name_ar' => 'قائمة أدوار المستخدمين']);
        // Permission::create(['name_fr' =>"Affichage d'utilisateurs" , 'name_ar' => 'عرض المستخدمين']);
        // Permission::create(['name_fr' =>'Ajouter un utilisateur' , 'name_ar' => 'إضافة مستخدم']);
        // Permission::create(['name_fr' =>'modifier un utilisateur' , 'name_ar' => 'تعديل مستخدم']);
        // Permission::create(['name_fr' =>'supprimer un utilisateur' , 'name_ar' => 'حذف مستخدم']);
        // Permission::create(['name_fr' =>'Activer un utilisateur' , 'name_ar' => 'تفعيل مستخدم']);
        // Permission::create(['name_fr' =>'Bloquer un utilisateur' , 'name_ar' => 'حظر  مستخدم']);
        // Permission::create(['name_fr' =>'restore un utilisateur' , 'name_ar' => 'استعادة مستخدم']);
        // Permission::create(['name_fr' =>'visualisez un utilisateur' , 'name_ar' => ' عرض المستخدم']);

        // Permission::create(['name_fr' =>'Affichage des Roles' , 'name_ar' => 'عرض الأدوار']);
        // Permission::create(['name_fr' =>'Ajouter un rôle' , 'name_ar' => 'اضافة دور']);
        // Permission::create(['name_fr' =>'Modifer un rôle' , 'name_ar' => 'تعديل دور']);
        // Permission::create(['name_fr' =>'Supprimer un rôle' , 'name_ar' => 'حذف دور']);
        // Permission::create(['name_fr' =>'visualisez un role' , 'name_ar' => 'عرض دور']);
        // Permission::create(['name_fr' =>'restore un role' , 'name_ar' => 'استعادة دور']);


        // $permissions = [
        //   'parameter-create', 
        //   'parameter-edit', 
        //   'parameter-list', 
        //   'parameter-delete', 
        //   'parameter-erase', 

        //   'basepf-create', 
        //   'basepf-edit', 
        //   'basepf-list', 
        //   'basepf-delete', 
        //   'basepf-erase',

        //   'basecs-create', 
        //   'basecs-edit', 
        //   'basecs-list', 
        //   'basecs-delete', 
        //   'basecs-erase',

        //   'basedr-create', 
        //   'basedr-edit', 
        //   'basedr-list', 
        //   'basedr-delete', 
        //   'basedr-erase',
        // ];

        // foreach($permissions as $permission){
        //   Permission::create(['name' => $permission]);
        // }

        ///1- SG MLM 
        //2- SD CS

          $i = 0;

         if($i == 1){

            // Role::create(['name' => 's-a']);
            // Role::create(['name' => 'pf']);
            // Role::create(['name' => 'apf']);
            // Role::create(['name' => 'cs']);
            // Role::create(['name' => 'acs']);
            // Role::create(['name' => 'd-r']);
            // Role::create(['name' => 'ad']);
            // Role::create(['name' => 'd-p']);
            // Role::create(['name' => 'dcs']);
            // Role::create(['name' => 'dcd']);
            // Role::create(['name' => 'dd']);

            // $us_ad = User::create([
            //   'name' => 'Hicham Chamich',
            //   'email' => 'directeur-a@gmail.com',
            //   'password' => bcrypt('12345678'),
            //   'domaine_id' => 33,
            // ]);
            // $us_acs = User::create([
            //   'name' => 'Hamid Mohammad',
            //   'email' => 'chef-a@gmail.com',
            //   'password' => bcrypt('12345678'),
            //   'domaine_id' => 33,
            // ]);
            // $us_apf = User::create([
            //   'name' => 'Samsoum Bilal',
            //   'email' => 'employe-a@gmail.com',
            //   'password' => bcrypt('12345678'),
            //   'domaine_id' => 33,
            // ]);

            $us_adm = User::where('id', 1)->first();
            $us_pf = User::where('id', 8)->first();
            $us_cs = User::where('id', 4)->first();
            $us_csr = User::where('id', 5)->first();
            $us_dp = User::where('id', 3)->first();
            $us_dr = User::where('id', 2)->first();
            $us_dcs = User::where('id', 10)->first();
            $us_dcd = User::where('id', 11)->first();
            $us_dd = User::where('id', 9)->first();
            $us_apf = User::where('id', 26)->first();
            $us_acs = User::where('id', 25)->first();
            $us_ad = User::where('id', 24)->first();

            // $admin = Role::findByName('s-a');
            // $pf = Role::findByName('pf');
            // $apf = Role::findByName('apf');
            // $cs = Role::findByName('cs');
            // $acs = Role::findByName('acs');
            // $dr = Role::findByName('d-r');
            // $ad = Role::findByName('ad');
            // $dp = Role::findByName('d-p');
            // $dcs = Role::findByName('dcs');
            // $dcd = Role::findByName('dcd');
            // $dd = Role::findByName('dd');

            $us_apf->assignRole('apf');
            $us_acs->assignRole('acs');
            $us_ad->assignRole('ad');
            $us_adm->assignRole('s-a');
            $us_pf->assignRole('pf');
            $us_cs->assignRole('cs');
            $us_csr->assignRole('cs');
            $us_dp->assignRole('d-p');
            $us_dr->assignRole('d-r');
            $us_dcs->assignRole('dcs');
            $us_dcd->assignRole('dcd');
            $us_dd->assignRole('dd');
         }
            $j=2;

         if($j==2){
          $admin = Role::findByName('s-a', 'web');
          $pf = Role::findByName('pf', 'web');
          $apf = Role::findByName('apf', 'web');
          $cs = Role::findByName('cs', 'web');
          $acs = Role::findByName('acs', 'web');
          $dr = Role::findByName('d-r', 'web');
          $ad = Role::findByName('ad', 'web');
          $dp = Role::findByName('d-p', 'web');
          $dcs = Role::findByName('dcs', 'web');
          $dcd = Role::findByName('dcd', 'web');
          $dd = Role::findByName('dd', 'web');
          
            $adm = Permission::findOrCreate('administrate');
            $sd = Permission::findOrCreate('sd');
            $ac = Permission::findOrCreate('ac');
            $dc = Permission::findOrCreate('dc');

            $vs = Permission::findOrCreate('view-select');
            $vp = Permission::findOrCreate('view-province');
            $vr = Permission::findOrCreate('view-region');
            
            $ve = Permission::findOrCreate('view-etats');
            $vrj = Permission::findOrCreate('view-rejets');
            $fi = Permission::findOrCreate('follow-info');
            $ao = Permission::findOrCreate('add-on'); //new-rea
            $a = Permission::findOrCreate('add'); //new-rea
            $dbt = Permission::findOrCreate('delete-basethree'); 
            $ddbt = Permission::findOrCreate('destroy-basethree'); 
            $dbo = Permission::findOrCreate('delete-baseone'); 
            $ddbo = Permission::findOrCreate('destroy-baseone'); 
            
            $v = Permission::findOrCreate('validate');
            $r = Permission::findOrCreate('reject');
            $e = Permission::findOrCreate('edit');
            $ey = Permission::findOrCreate('edit-annee');
            $eo = Permission::findOrCreate('edit-global-goal');

            $perms_for_pf =  [ $sd  , $vp, $v,  $ao, $vrj, $e];
            $perms_for_apf = [ $ac  , $vp, $v, $r, $ao, $vrj, $e];
            $perms_for_cs =  [ $sd  , $vp, $v, $r, $ao, $vrj, $e];
            $perms_for_acs = [ $ac  , $vp, $v, $r, $ao, $vrj, $e];
            $perms_for_dcs = [ $dc  , $vs, $v, $r ];
            $perms_for_dcd = [ $dc  , $vs, $v, $r, $fi];
            $perms_for_dp =  [ $sd  , $vp, $v, $r,$a, $ve, $fi];
            $perms_for_dr =  [ $sd  , $vr, $v, $r,$a, $ve, $fi];
            $perms_for_ad =  [ $ac  , $vp, $v, $r,$a, $ve, $fi];
            $perms_for_dd =  [ $dc  , $vs,  $r, $ve, $fi];
            $perms_for_adm = [ $adm , $vs,  $r, $ey, $eo, $dbt, $ddbt, $dbo, $ddbo];

            foreach($perms_for_pf as $action){
              $action->assignRole($pf);
            }
            foreach($perms_for_apf as $action){
              $action->assignRole($apf);
            }
            foreach($perms_for_cs as $action){
              $action->assignRole($cs);
            }
            foreach($perms_for_acs as $action){
              $action->assignRole($acs);
            }
            foreach($perms_for_dcs as $action){
              $action->assignRole($dcs);
            }
            foreach($perms_for_dcd as $action){
              $action->assignRole($dcd);
            }
            foreach($perms_for_dp as $action){
              $action->assignRole($dp);
            }
            foreach($perms_for_dr as $action){
              $action->assignRole($dr);
            }
            foreach($perms_for_ad as $action){
              $action->assignRole($ad);
            }
            foreach($perms_for_dd as $action){
              $action->assignRole($dd);
            }
            foreach($perms_for_adm as $action){
              $action->assignRole($admin);
            }
            
          return 1;
         }

          if($i==321){
            $ir = Permission::create(['name' => 'insert-real']);
            $vr = Permission::create(['name' => 'view-rejet']);
            $egg = Permission::create(['name' => 'edit-global-goal']);
            $fi = Permission::create(['name' => 'follow-info']);

            $cs =    Role::findByName('cs');
            $pf =    Role::findByName('point focal');
            $dp =   Role::findByName('d-r');
            $ten =  Role::findByName('dcs');
            $nine =  Role::findByName('dcd');
            $eight =  Role::findByName('dd');

            $dp->givePermissionTo($egg);
            $eight->givePermissionTo($egg);

            $cs->givePermissionTo($ir);
            $pf->givePermissionTo($ir);

            $eight->givePermissionTo($fi);
            $dp->givePermissionTo($fi);

            return 1;
          }

        $admin = Role::create(['name' => 's-a']);
        $pf = Role::create(['name' => 'pf']);
        $cs = Role::create(['name' => 'cs']);
        $dr = Role::create(['name' => 'd-r']);
        $dp = Role::create(['name' => 'd-p']);
        $dcs = Role::create(['name' => 'dcs']);
        $dcd = Role::create(['name' => 'dcd']);
        $dd = Role::create(['name' => 'dd']);


        $parametres = [
          'rhsds',
          'budgets',
          'attprocs',
          'indicperfs',
        ];
        $validation_parameters = [
          'rhsds',
          'budgets',
          'indicperfs',
          'attprocs'
        ];

        foreach($parametres as $parametre){
          $perm = [
            'access-'.$parametre,
            'create-'.$parametre,
            'edit-'.$parametre,
            'delete-'.$parametre,
            'erase-'.$parametre,
            'restore-'.$parametre,
          ];
        if(in_array($parametre, $validation_parameters)){
          $validation_permissions = [
            'validate-'.$parametre,
            'reject-'.$parametre,
          ];
          foreach($validation_permissions as $vp) {
            array_push($perm, $vp);
          }
        }
          foreach($perm as $p){
            
              $action = Permission::findOrCreate($p);

            if(preg_match('/^access-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($pf);
              // $action->assignRole($cs);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($dcs);
              // $action->assignRole($dcd);
              // $action->assignRole($dd);              
              // $action->assignRole($eight);
            }
            if(preg_match('/^create-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($pf);
              // $action->assignRole($cs);
            }
            if(preg_match('/^edit-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($pf);
              // $action->assignRole($cs);
              // $action->assignRole($dp);
              // $action->assignRole($dr);
            }
            
            if(preg_match('/^delete-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($eight);
              $action->assignRole($ten);
            }
            if(preg_match('/^erase-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^restore-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($eight);
            }
            if(preg_match('/^validate-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^reject-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($dr);
              // $action->assignRole($dp);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
          }
        }
    }
}

