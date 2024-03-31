<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ServiceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('websiteName')->group(function () {
    // Route::post('/slider',[SliderController::class,'store']);
    // Route::get('/sliders', [SliderController::class,'index']);
    // Route::get('/slider/{id}',[SliderController::class,'show']);
    // Route::post('/slider/{id}', [SliderController::class,'update']);
    // Route::delete('/slider/{id}', [SliderController::class,'delete']);

    // Route::post('/service',[ServiceController::class,'store']);
    // Route::get('/services', [ServiceController::class,'index']);
    // Route::get('/service/{id}',[ServiceController::class,'show']);
    // Route::post('/service/{id}', [ServiceController::class,'update']);
    // Route::delete('/service/{id}', [ServiceController::class,'delete']);

    // Route::post('/company_service',[CompanyServiceController::class,'store']);
    // Route::get('/company_services', [CompanyServiceController::class,'index']);
    // Route::get('/company_service/{id}',[CompanyServiceController::class,'show']);
    // Route::post('/company_service/{id}', [CompanyServiceController::class,'update']);
    // Route::delete('/company_service/{id}', [CompanyServiceController::class,'delete']);

    // Route::post('/company_profile',[CompanyProfilesController::class,'store']);
    // Route::get('/company_profiles', [CompanyProfilesController::class,'index']);
    // Route::get('/company_profile/{id}',[CompanyProfilesController::class,'show']);
    // Route::post('/company_profile/{id}', [CompanyProfilesController::class,'update']);
    // Route::delete('/company_profile/{id}', [CompanyProfilesController::class,'delete']);

    // Route::post('/company_objective',[CompanyObjectiveController::class,'store']);
    // Route::get('/company_objectives', [CompanyObjectiveController::class,'index']);
    // Route::get('/company_objective/{id}',[CompanyObjectiveController::class,'show']);
    // Route::post('/company_objective/{id}', [CompanyObjectiveController::class,'update']);
    // Route::delete('/company_objective/{id}', [CompanyObjectiveController::class,'delete']);
});
