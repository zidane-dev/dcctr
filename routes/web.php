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
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
        Route::get('/logout', 'HomeController@logout')->name('dashboard.logout');
        ####################### Parametres 1
        Route::resource('axes', 'AxeController')->except(['show']);
        Route::resource('regions', 'DrController')->except(['show']);
        Route::resource('indicateurs', 'IndicateurController')->except(['show']);
        Route::resource('qualites', 'QualiteController')->except(['show']);
        Route::resource('secteurs', 'SecteurController')->except(['show']);
        Route::resource('structures', 'StructureController')->except(['show']);
        Route::resource('unites', 'UniteController')->except(['show']);
        Route::resource('typecredits', 'TypeCreditController')->except(['show']);
        ####################### Parametres 2
        Route::resource('attributions', 'AttributionController')->except(['show']);
        Route::resource('dpcis', 'DpciController')->except(['show']);
        Route::resource('objectifs', 'ObjectifController')->except(['show']);
        ####################### Parametres 3
        ############    RH
        ########    SD
        Route::get('index/{year?}', 'RhsdController@index')->name('rhs.index');
        Route::resource('rhs', 'RhsdController');
        Route::get('indexyear/{year?}', 'RhsdController@indexYear')->name('rhs.indexYear');
        Route::get('rh/validation', 'RhsdController@get_validation')->name('rhs.validation');
        Route::post('send_rhs','RhsdController@update_etat')->name('update_etat');
        Route::get('realisationrh/{id}','RhsdController@nouvelle_realisation')->name('rhs.storereal');
        Route::get('newobjrh/{id}','RhsdController@edit_goal')->name('edit.rhsgoal');
        Route::put('newobjrh/{id}','RhsdController@update_goal')->name('update.rhsgoal');
        Route::post('rejet','RhsdController@rejection')->name('rejet');
        ########    DC SASD
        Route::get('indexo', 'RhsdController@indexByQuery')->name('indexByQuery');
        Route::get('regs', 'RhsdController@get_domaineGroupByReg')->name('subReg');
        ############    AttProc

        Route::resource('attprocs', 'AttProcController');
        ############    AXE X
        
        ####################### Users
        Route::resource('users', 'UserController');
        Route::get('/rights', 'TestController@index')->name('rights');
        ####################### Archives
        Route::resource('archives', 'ArchiveController');
    }); 
}); 

