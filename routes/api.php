<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PriceController;

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

Route::group(['middleware' => 'api'], function(){
    /* User register */
    Route::post('/register', [AuthController::class, 'register']);
    /* User login */
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    /* Reset password */
    Route::post('/reset/password', [AuthController::class, 'resetPassword']);

    /* Refresh user's token */
    Route::get('/refresh', [AuthController::class, 'token']);
    /* User logout from system */
    Route::get('/logout', [AuthController::class, 'logout']);
    // Get auth user
    Route::get('/token/validate', [AuthController::class, 'auth']);

    // Get user's profile
    Route::get('/profile', [ProfileController::class, 'index']);
    // Update user's profile
    Route::put('/profile/update', [ProfileController::class, 'update']);

    // Get all projects
    Route::get('/projects', [ProjectController::class, 'getAll']);
    /* Get project detail by id */
    Route::get('/project/{projectId}', [ProjectController::class, 'getById']);
    /* Update project's status */
    Route::put('/project/set-status', [ProjectController::class, 'setStatus']);

    // Get all projects
    Route::get('/work/formats', [ProjectController::class, 'getWorkFormats']);

    //Admin actions
    Route::group([ 'prefix' => 'admin', 'middleware' => 'isAdmin' ], function(){
        /* Get all users details*/
        Route::get('/users', [UserController::class, 'getAll']);
        /* Add a user */
        Route::post('/user/create', [UserController::class, 'create']);
        /* Update a user */
        Route::put('/user/update', [UserController::class, 'update']);
        /* Get user detail by id */
        Route::get('/user/{userId}', [UserController::class, 'getById']);
        /* delete user by id */
        Route::delete('/user/delete/{userId}', [UserController::class, 'delete']);

        /* Get all businesses*/
        Route::get('/businesses', [UserController::class, 'getAllBusinesses']);
        /* Get price list*/
        Route::get('/prices', [PriceController::class, 'index']);
        /* Update price list */
        Route::put('/price/update', [PriceController::class, 'update']);

        // Assign project to a business
        Route::put('/project/assign', [ProjectController::class, 'assignProject']);
        // delete project by id
        Route::delete('/project/{projectId}/delete', [ProjectController::class, 'delete']);
        // delete deliverable data
        Route::delete('/project/deliverable-data/{dataId}/delete', [ProjectController::class, 'deleteDeliverableData']);
        // delete request data
        Route::delete('/project/request-data/{dataId}/delete', [ProjectController::class, 'deleteRequestData']);
    });

    //Client actions
    Route::group([ 'prefix' => 'client', 'middleware' => 'isClient' ], function(){
        /* Create a new project */
        Route::post('/project/create', [ProjectController::class, 'create']);
        /* Update a project detail */
        Route::put('/project/update', [ProjectController::class, 'update']);
        /* Add a new request data */
        Route::post('/project/request-data/add', [ProjectController::class, 'addRequestData']);
    });

    //Business actions
    Route::group([ 'prefix' => 'business', 'middleware' => 'isBusiness' ], function(){
        /* Add a new deliverable data */
        Route::post('/project/deliverable-data/add', [ProjectController::class, 'addDeliverableData']);
    });
});
