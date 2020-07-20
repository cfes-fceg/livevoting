<?php

use App\Role\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'VoterController@index')->middleware(['auth', 'check_user_role:' . UserRole::ROLE_VOTER])->name('voter.home');

Route::group([
    'prefix' => 'vote',
    'middleware' => ['auth','check_user_role:' . UserRole::ROLE_VOTER]
], function(){
    Route::get('/', 'EngSocsController@index')
        ->name('eng_socs.eng_soc.index');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth','check_user_role:' . UserRole::ROLE_ADMIN]
], function(){

    Route::group([
        'prefix' => 'engsocs',
    ], function () {
        Route::get('/', 'EngSocsController@index')
            ->name('eng_socs.eng_soc.index');
        Route::get('/create','EngSocsController@create')
            ->name('eng_socs.eng_soc.create');
        Route::get('/{engSoc}/edit','EngSocsController@edit')
            ->name('eng_socs.eng_soc.edit')->where('id', '[0-9]+');
        Route::post('/', 'EngSocsController@store')
            ->name('eng_socs.eng_soc.store');
        Route::put('eng_soc/{engSoc}', 'EngSocsController@update')
            ->name('eng_socs.eng_soc.update')->where('id', '[0-9]+');
        Route::delete('/eng_soc/{engSoc}','EngSocsController@destroy')
            ->name('eng_socs.eng_soc.destroy')->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'questions',
    ], function () {
        Route::get('/', 'QuestionsController@index')
            ->name('questions.question.index');
        Route::get('/create','QuestionsController@create')
            ->name('questions.question.create');
        Route::get('/show/{question}','QuestionsController@show')
            ->name('questions.question.show')->where('id', '[0-9]+');
        Route::get('/{question}/edit','QuestionsController@edit')
            ->name('questions.question.edit')->where('id', '[0-9]+');
        Route::post('/', 'QuestionsController@store')
            ->name('questions.question.store');
        Route::put('question/{question}', 'QuestionsController@update')
            ->name('questions.question.update')->where('id', '[0-9]+');
        Route::delete('/question/{question}','QuestionsController@destroy')
            ->name('questions.question.destroy')->where('id', '[0-9]+');
    });

});
