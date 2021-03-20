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
})->name('root');

//Auth::routes();
Route::POST('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::GET('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::GET('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::POST('logout', 'Auth\LoginController@logout')->name('logout');
Route::POST('password/confirm', 'Auth\ConfirmPasswordController@confirm');
Route::GET('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::POST('login', 'Auth\LoginController@login')->name('login');
Route::POST('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::GET('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::POST('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::GET('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::POST('register', 'Auth\RegisterController@register')->name('register');

Route::get('/home', 'VoterController@index')->middleware(['auth', 'verified', 'check_user_role:' . UserRole::ROLE_VOTER])->name('voter.home');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'verified', 'check_user_role:' . UserRole::ROLE_ADMIN]
], function () {

    Route::get('/', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::group([
        'prefix' => 'engsocs',
    ], function () {
        Route::get('/', 'EngSocsController@index')
            ->name('admin.engsocs');
        Route::get('/new', 'EngSocsController@create')
            ->name('admin.engsocs.new');
        Route::get('/{engSoc}/edit', 'EngSocsController@edit')
            ->name('admin.engsocs.edit')->where('id', '[0-9]+');
        Route::post('/', 'EngSocsController@store')
            ->name('admin.engsocs.store');
        Route::put('/{engSoc}', 'EngSocsController@update')
            ->name('admin.engsocs.update')->where('id', '[0-9]+');
        Route::delete('/{engSoc}', 'EngSocsController@destroy')
            ->name('admin.engsocs.destroy')->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'questions',
    ], function () {
        Route::get('/', 'QuestionsController@index')
            ->name('admin.questions');
        Route::get('/create', 'QuestionsController@create')
            ->name('admin.questions.create');
        Route::get('/active', 'QuestionsController@active')
            ->name('admin.questions.active');
        Route::get('/{question}', 'QuestionsController@show')
            ->name('admin.questions.show')->where('id', '[0-9]+');
        Route::get('/{question}/edit', 'QuestionsController@edit')
            ->name('admin.questions.edit')->where('id', '[0-9]+');
        Route::get('/{question}/pdf', 'QuestionsController@pdf')
            ->name('admin.questions.pdf');
        Route::post('/', 'QuestionsController@store')
            ->name('admin.questions.store');
        Route::put('/{question}', 'QuestionsController@update')
            ->name('questions.question.update')->where('id', '[0-9]+');
        Route::delete('/{question}', 'QuestionsController@destroy')
            ->name('admin.questions.destroy')->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'users',
    ], function () {
        Route::get('/', 'UsersController@index')
            ->name('admin.users');
        Route::put('/{user}', 'UsersController@update')
            ->name('admin.users.update');
        Route::delete('/{user}', 'UsersController@destroy')
            ->name('admin.users.destroy')->where('user', '[0-9]+');
//        Route::get('/user/{user}/sendResetEmail', 'UsersController@sendResetLink')
//            ->name('admin.users.sendResetLink')->where('user', '[0-9]+');
        Route::get('/{user}/edit', 'UsersController@edit')
            ->name('admin.users.edit')->where('user', '[0-9]+');
    });

});
