<?php

use App\Role\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'middleware' => ['auth:api']
], function () {
    Route::group([
        'middleware' => ['check_user_role:' . UserRole::ROLE_VOTER]
    ], function() {
        Route::post('/questions/{question}/votes', 'VoterController@castBallot');
    });

    Route::group([
        'middleware' => ['check_user_role:' . UserRole::ROLE_ADMIN]
    ], function() {
        Route::put('/engsocs/{id}', 'EngSocsController@apiUpdate');
        Route::get('/questions/{question}/results','QuestionsController@getResults');
    });

    Route::get('/questions/active', 'VoterController@getActiveQuestions');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


