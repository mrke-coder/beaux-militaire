<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/',function (){
   return view('auth.login');
});
Route::group(['middleware' => 'auth'], function (){
    Route::post('/logout','AuthController@logout')->name('auth.logout');
    Route::get('/nouvel-utilisateur', function (){
        return view('pages.auth.register');
    });
    Route::post('/register','AuthController@store')->name('auth.store');

    Route::group(['prefix' => 'dashboard'], function (){
        Route::get('/','HomeController@index')->name('home');

        // militaires routes

        Route::get('/militaires','MilitaireController@index')->name('militaire.home');
        Route::get('/militaire/{id}','MilitaireController@show')->name('militaire.show');
        Route::get('/militaire/delete/{id}','MilitaireController@destroy_partial')->name('militaire.delete');
        Route::get('/militaire/{id}/informations','MilitaireController@details')->name('militaire.fiche');
        Route::post('/militaires','MilitaireController@storeOrUpdate')->name('militaire.store');
        Route::post('/militaire-grade','MilitaireGradeController@store')->name('militaire.store_grade');
        Route::post('/militaire/edit-photo','MilitaireController@update_photo')->name('militaire.photo');

        // grades routes

        Route::get('/grades-militaires', 'GradeController@index')->name('grade.home');
        Route::get('/grades-militaires/{id}','GradeController@show')->name('grade.show');
        Route::get('/grades-militaires/{id}/delete','GradeController@destroy')->name('grade.delete');
        Route::post('/grades-militaires', 'GradeController@store')->name('grade.store');

        // Type Logement routes

        Route::get('/type-de-logemets','TypeLogementController@index')->name('typeL.home');
        Route::get('/type-de-logemets/{id}','TypeLogementController@show')->name('typeL.show');
        Route::get('/type-de-logemets/{id}/delete','TypeLogementController@destroy')->name('typeL.delete');
        Route::post('/type-de-logemets','TypeLogementController@store')->name('typeL.store');

        // Emplacement routes
        Route::get('/emplacements','EmplacementController@index')->name('emplacement.home');
        Route::post('/emplacements','EmplacementController@store')->name('emplacement.store');
        Route::get('/emplacements/{id}','EmplacementController@show')->name('emplacement.show');
        Route::get('/emplacements/{id}/delete','EmplacementController@destroy')->name('emplacement.delete');

        // Logements Routes
        Route::get('/logements','LogementController@index')->name('logement.home');
        Route::post('/logements','LogementController@store')->name('logement.store');
        Route::get('/logements/{id}','LogementController@show')->name('logement.edit');
        Route::get('/logement/{id}/delete','LogementController@destroy')->name('logement.delete');
        Route::get('/logement/{id}/informations','LogementController@informations')->name('logement.infos');

        // Anciens Logements routes

        Route::get('/anciens_logements','AncienLogementController@index')->name('ancienL.home');
        Route::get('/anciens_logements/{id}','AncienLogementController@show');
        Route::get('/anciens_logements/{id}/delete','AncienLogementController@destroy');
        Route::post('/anciens_logements','AncienLogementController@store')->name('ancienL.store');

        // Propriétaires Routes
        Route::get('/proprietaires','PropietaireController@index')->name('proprio.home');
        Route::post('/proprietaires','PropietaireController@store')->name('proprio.store');
        Route::get('/proprietaires/{id}','PropietaireController@show')->name('proprio.show');
        Route::delete('/proprietaires/{id}/delete','PropietaireController@destroy')->name('proprio.delete');
        Route::get('/proprietaires/{id}/informations', 'PropietaireController@infos');

        // Compte routes

        Route::get('/comptes', 'CompteController@index')->name('compte.home');
        Route::get('/comptes/{id}', 'CompteController@show')->name('compte.edit');
        Route::get('/comptes/{id}/delete', 'CompteController@destroy')->name('compte.delete');
        Route::get('/comptes/{id}/informations', 'CompteController@infos')->name('compte.show');
        Route::post('/comptes', 'CompteController@store')->name('compte.store');

        // USER MANAGEMENT ROUTES

        Route::get('/utilisateurs', 'UserController@index')->name('user.home');
        Route::post('/utilisateurs', 'UserController@store')->name('user.store');
        Route::get('/utilisateurs/{id}', 'UserController@show')->name('user.show');
        Route::get('/utilisateurs/{id}/delete', 'UserController@destroy')->name('user.show');

        // ROLE ROUTES

        Route::resource('habilitations','RoleController');
    });
});

Auth::routes(['register' => false]);

//Route::get('/home', 'HomeController@index')->name('home');
