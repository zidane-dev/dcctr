<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

####################### Dashboard, Master
Route::post('/logout', 'HomeController@logout')->name('dashboard.logout');


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'],function (){
    Route::group(['prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect',
    'localizationRedirect', 
    'localeViewPath']], function(){
        ####################### General
        
        Route::get('/dashboard'             , 'DashboardController@index')      ->name('dashboard.index');
        Route::get('/logout'                , 'HomeController@logout')          ->name('dashboard.logout');
        
        ####################### Parametres 1 & 2
        Route::group(['middleware'=>['permission:administrate']], function(){
            Route::resource('archives'              , 'ArchiveController');
            
            // Route::get('assign', 'PermissionController@index')->name('permission.index');
            
            Route::group(['namespace' => 'Parametres'], function() {
                Route::resource('axes'              , 'AxeController'          )->except(['show']);
                Route::resource('regions'           , 'DrController'           )->except(['show']);
                Route::resource('indicateurs'       , 'IndicateurController'   )->except(['show']);
                Route::resource('qualites'          , 'QualiteController'      )->except(['show']);
                Route::resource('secteurs'          , 'SecteurController'      )->except(['show']);
                Route::resource('structures'        , 'StructureController'    )->except(['show']);
                Route::resource('ressources'        , 'RessourceController'    )->except(['show']);
                Route::resource('unites'            , 'UniteController'        )->except(['show']);
                // Route::resource('typecredits'    , 'TypeCreditController'   )->except(['show']);
                Route::resource('attributions'      , 'AttributionController'  )->except(['show']);
                Route::resource('dpcis'             , 'DpciController'         )->except(['show']);
                Route::resource('objectifs'         , 'ObjectifController'     )->except(['show']);
                Route::resource('depenses'          , 'DepenseController'      )->except(['show']);
            });
        });

        ####################### Parametres 3
        Route::group(['prefix' => 'axe', 'namespace'=>'Axes'], function(){
            ###########################   SD / AC
            ############    RH
            Route::get('index/{year?}'          , 'RhsdController@index'                     )->name('rhs.index');
            Route::get('realisationrh/{id}'     , 'RhsdController@add_on'                    )->name('rhs.storereal');
            Route::get('newobjrh/{id}'          , 'RhsdController@edit_goal'                 )->name('edit.rhsgoal');
            Route::put('newobjrh/{id}/submit'   , 'RhsdController@update_goal'               )->name('update.rhsgoal');
            Route::resource('rhs'               , 'RhsdController');
            ############    ATT PROC
            Route::resource('attprocs'          , 'AttProcController');
            ############    BUDGET
            Route::resource('budgets'           , 'BudgetController');
            ############    INDICPERFS
            ##########################   DC
            Route::get('regs'                   , 'AxeHelperController@get_domaineGroupByReg')->name('subReg');
            Route::get('/dc/index'              , 'AxeHelperController@indexByQuery'         )->name('indexByQuery');
        });
        ####################### Users
       
        Route::resource('users'                 , 'UserController');
        Route::get('/rights'                    , 'TestController@index')                    ->name('rights');
        Route::get('/rightsofrole/{id}'         , 'TestController@assign_to_role')           ->name('rights_role');
        Route::get('/rightsofuser/{id}'         , 'TestController@assign_to_user')           ->name('rights_user');
        Route::put('/permissions/update'        , 'TestController@update_permissions')       ->name('rights.update');
        ####################### Uploads
        Route::group(['prefix' => 'uploads', 'namespace'=>'Rapports'], function(){
            Route::resource('documents', 'ReportController')->only(['index', 'create', 'store', 'destroy']);
        });

        ############################Validation
        
        Route::group(['prefix' => 'validation', 'namespace'=>'Validation'], function(){
            Route::get('ressourceshumaines'         , 'RhValidationController@index'           )->name('validation.rhsds');
            Route::get('ressourcesmaterielles'      , 'BdgValidationController@index'          )->name('validation.budgets');
            Route::get('attributionsetdelegations'  , 'AdgValidationController@index'          )->name('validation.att_procs');
            Route::get('indicateurs'                , 'IdpValidationController@index'          )->name('validation.indic_perfs');

            Route::post('submit/rh'                 , 'RhValidationController@valider'         )->name('valider.rhsds');
            Route::post('submitrejet/rh'            , 'RhValidationController@rejeter'         )->name('rejeter.rhsds');

            Route::post('submit/rm'                 , 'BdgValidationController@valider'        )->name('valider.budgets');
            Route::post('submitrejet/rm'            , 'BdgValidationController@rejeter'        )->name('rejeter.budgets');

            Route::post('submit/a&d'                , 'AdgValidationController@valider'        )->name('valider.att_procs');
            Route::post('submitrejet/a&d'           , 'AdgValidationController@rejeter'        )->name('rejeter.att_procs');

            // Route::post('submit/idp'                , 'IdpValidationController@valider'        )->name('valider.indic_perfs');
            // Route::post('submitrejet/idp'           , 'IdpValidationController@rejeter'        )->name('rejeter.indic_perfs');

        });
        Route::get('session', 'TestController@session')->name('show.session');
        Route::get('request', 'TestController@requete')->name('show.requete');
    }); 
}); 

