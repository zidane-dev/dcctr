<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        //   'baseone-create', 
        //   'baseone-edit', 
        //   'baseone-list', 
        //   'baseone-delete', 
        //   'baseone-erase',

        //   'basetwo-create', 
        //   'basetwo-edit', 
        //   'basetwo-list', 
        //   'basetwo-delete', 
        //   'basetwo-erase',

        //   'basethree-create', 
        //   'basethree-edit', 
        //   'basethree-list', 
        //   'basethree-delete', 
        //   'basethree-erase',
        // ];

        // foreach($permissions as $permission){
        //   Permission::create(['name' => $permission]);
        // }

        ///1- SG MLM 
        //2- SD CS

          $i = 321;

          // Permission::create(['name' => 'dcsasd']);
          // Permission::create(['name' => 'sd']);
          // Permission::create(['name' => 'administrate']);  //?
          // Permission::create(['name' => 'view-region']);
          // Permission::create(['name' => 'view-province']);
          // Permission::create(['name' => 'validate-only']);
          // Permission::create(['name' => 'reject-only']);
          // Permission::create(['name' => 'insert-real']);

          if($i==321){
            $ir = Permission::create(['name' => 'insert-real']);
            $egg = Permission::create(['name' => 'edit-global-goal']);
            $fi = Permission::create(['name' => 'follow-info']);

            $two =    Role::findByName('cs');
            $one =    Role::findByName('point focal');
            $four =   Role::findByName('d-r');
            $ten =  Role::findByName('dcs');
            $nine =  Role::findByName('dcd');
            $eight =  Role::findByName('dd');

            $four->givePermissionTo($egg);
            $eight->givePermissionTo($egg);

            $two->givePermissionTo($ir);
            $one->givePermissionTo($ir);

            $eight->givePermissionTo($fi);
            $four->givePermissionTo($fi);

            return 1;
          }

        // $role = Role::create(['name' => 'point focal']);
        // $role = Role::create(['name' => 'cs']);
        // $role = Role::create(['name' => 'dp']);
        // $role = Role::create(['name' => 'dr']);
        // $role = Role::create(['name' => 'dcs']);
        // $role = Role::create(['name' => 'dcd']);
        // $role = Role::create(['name' => 'dd']);
        // $role = Role::create(['name' => 'management']);
        // $role = Role::create(['name' => 'mlm']);
        // $role = Role::create(['name' => 'dcsasd']);
        // $role = Role::create(['name' => 's-a']);

        $admin =  Role::findByName('s-a');
        $ten =  Role::findByName('dcs');
        $nine =  Role::findByName('dcd');
        // $eight =  Role::findByName('dcsasd');
        // $seven =  Role::findByName('management');
        // $six =    Role::findByName('mlm');
        // $five =   Role::findByName('ss');
        // $four =   Role::findByName('d-r');
        // $three =  Role::findByName('d-p');
        // $two =    Role::findByName('cs');
        // $one =    Role::findByName('point focal');

        $parametres = [
          'axes', 
          'attributions',
          'dpcis', 
          'regions', 
          'indicateurs', 
          'objectifs', 
          'qualites',
          'secteurs',
          'structures',
          'typecredits',
          'unites',
          'rhsds'
        ];
        $validation_parameters = [
          'rhsds',
          'attprocs'
        ];

        foreach($parametres as $parametre){
          $perm = [
            'access-'.$parametre,
            'create-'.$parametre,
            'edit-'.$parametre,
            'list-'.$parametre,
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
            if(! Permission::findByName($p))
              $action = Permission::create(['name' => $p]);
            else
              $action = Permission::findByName($p);

            if(preg_match('/^access-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($one);
              // $action->assignRole($two);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($five);
              // $action->assignRole($six);
              // $action->assignRole($seven);              
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^create-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($one);
              // $action->assignRole($two);
            }
            if(preg_match('/^edit-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($one);
              // $action->assignRole($two);
              // $action->assignRole($four);
              // $action->assignRole($three);
            }
            if(preg_match('/^list-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($one);
              // $action->assignRole($two);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($five);
              // $action->assignRole($six);
              // $action->assignRole($seven);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^delete-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($eight);
              $action->assignRole($ten);
            }
            if(preg_match('/^erase-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^restore-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($eight);
            }
            if(preg_match('/^validate-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
            if(preg_match('/^reject-/', $p)){
              // $action->assignRole($admin);
              // $action->assignRole($three);
              // $action->assignRole($four);
              // $action->assignRole($eight);
              $action->assignRole($nine);              
              $action->assignRole($ten);
            }
          }
        }
    }
}

