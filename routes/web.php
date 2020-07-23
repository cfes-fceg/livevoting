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
    $user = Auth::user();
    if ($user) {
        if ($user->hasRole(UserRole::ROLE_ADMIN)) {// do your magic here
            return redirect()->route('admin.home');
        } else if ($user->hasRole(UserRole::ROLE_VOTER)) {
            return redirect()->route('voter.home');
        }
    }
    return view('welcome');
});


//Auth::routes();

//Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::POST('login', 'Auth\LoginController@login')->name('login');
Route::POST('logout', 'Auth\LoginController@logout')->name('logout');
Route::POST('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::GET('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::POST('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::GET('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::POST('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::GET('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::POST('register', 'Auth\RegisterController@register')->name('register');
//Route::GET('register', 'Auth\RegisterController@showRegistrationForm');

Route::get('/home', 'VoterController@index')->middleware(['auth', 'check_user_role:' . UserRole::ROLE_VOTER])->name('voter.home');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'check_user_role:' . UserRole::ROLE_ADMIN]
], function () {

    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::group([
        'prefix' => 'engsocs',
    ], function () {
        Route::get('/', 'EngSocsController@index')
            ->name('admin.engsocs');
        Route::get('/create', 'EngSocsController@create')
            ->name('admin.engsocs.create');
        Route::get('/{engSoc}/edit', 'EngSocsController@edit')
            ->name('admin.engsocs.edit')->where('id', '[0-9]+');
        Route::post('/', 'EngSocsController@store')
            ->name('admin.engsocs.store');
        Route::put('eng_soc/{engSoc}', 'EngSocsController@update')
            ->name('admin.engsocs.update')->where('id', '[0-9]+');
        Route::delete('/eng_soc/{engSoc}', 'EngSocsController@destroy')
            ->name('admin.engsocs.destroy')->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'questions',
    ], function () {
        Route::get('/', 'QuestionsController@index')
            ->name('admin.questions');
        Route::get('/create', 'QuestionsController@create')
            ->name('admin.questions.create');
        Route::get('/show/{question}', 'QuestionsController@show')
            ->name('admin.questions.show')->where('id', '[0-9]+');
        Route::get('/{question}/edit', 'QuestionsController@edit')
            ->name('admin.questions.edit')->where('id', '[0-9]+');
        Route::post('/', 'QuestionsController@store')
            ->name('admin.questions.store');
        Route::put('question/{question}', 'QuestionsController@update')
            ->name('questions.question.update')->where('id', '[0-9]+');
        Route::delete('/question/{question}', 'QuestionsController@destroy')
            ->name('admin.questions.destroy')->where('id', '[0-9]+');
    });

});
