<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FooterLinkController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebFormController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/auth/midata', [AuthController::class, 'redirectToProvider']);
Route::post('/auth/midata/callback', [AuthController::class, 'handleProviderCallback']);

Route::middleware('auth:sanctum')->get('/user/info', [UserController::class, 'getUserInfo']);

Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::get('/users', [UserController::class, 'index']);
});

//Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/groups', [GroupController::class, 'index']);
Route::get('/groups/{id}', [GroupController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::post('/groups', [GroupController::class, 'store']);
    Route::put('/groups/{id}', [GroupController::class, 'update']);
    Route::delete('/groups/{id}', [GroupController::class, 'destroy']);
});

Route::get('/sections', [SectionController::class, 'index']);
Route::get('/sections/{id}', [SectionController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::post('/sections', [SectionController::class, 'store']);
    Route::put('/sections/{id}', [SectionController::class, 'update']);
    Route::delete('/sections/{id}', [SectionController::class, 'destroy']);
});


Route::get('/pages/{id}', [PageController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::get('/pages', [PageController::class, 'index']);
    Route::post('/pages', [PageController::class, 'store']);
    Route::put('/pages/{id}', [PageController::class, 'update']);
    Route::delete('/pages/{id}', [PageController::class, 'destroy']);
});


Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::get('/files', [FileController::class, 'index']);
    Route::post('/files', [FileController::class, 'store']);
    Route::get('/files/{id}', [FileController::class, 'show']);
    Route::put('/files/{id}', [FileController::class, 'update']);
    Route::post('/files/{id}', [FileController::class, 'update']);
    Route::delete('/files/{id}', [FileController::class, 'destroy']);
});

Route::get('/contacts', [ContactController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::get('/contacts/{id}', [ContactController::class, 'show']);
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::put('/contacts/{id}', [ContactController::class, 'update']);
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
});


Route::get('/forms/{id}', [FormController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::get('/forms', [FormController::class, 'index']);
    Route::post('/forms', [FormController::class, 'store']);
    Route::put('/forms/{id}', [FormController::class, 'update']);
    Route::delete('/forms/{id}', [FormController::class, 'destroy']);
});

Route::get('/menuitems', [MenuItemController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::post('/menuitems', [MenuItemController::class, 'store']);
    Route::delete('/menuitems/{id}', [MenuItemController::class, 'destroy']);
});

Route::get('/settings', [SettingController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::put('/settings', [SettingController::class, 'update']);
});

Route::get('/locations', [LocationController::class, 'index']);
Route::get('/locations/{id}', [LocationController::class, 'show']);
Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::post('/locations', [LocationController::class, 'store']);
    Route::put('/locations/{id}', [LocationController::class, 'update']);
    Route::delete('/locations/{id}', [LocationController::class, 'destroy']);
});

Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/events', [EventController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::post('/events/sync', [EventController::class, 'syncExternalEvents']);
});

Route::get('/footerlinks', [FooterLinkController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::get('/footerlinks/{id}', [FooterLinkController::class, 'show']);
    Route::post('/footerlinks', [FooterLinkController::class, 'store']);
    Route::put('/footerlinks/{id}', [FooterLinkController::class, 'update']);
    Route::delete('/footerlinks/{id}', [FooterLinkController::class, 'destroy']);
});

Route::get('/camps', [CampController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::get('/camps/{id}', [CampController::class, 'show']);
    Route::post('/camps', [CampController::class, 'store']);
    Route::put('/camps/{id}', [CampController::class, 'update']);
    Route::delete('/camps/{id}', [CampController::class, 'destroy']);
    Route::post('/camps/sync', [CampController::class, 'syncExternalCamps']);
});

Route::get('/faqs', [FaqController::class, 'index']);
Route::group(['middleware' => ['auth:sanctum', 'roleOr:admin,unitleader']], function() {
    Route::get('/faqs/{id}', [FaqController::class, 'show']);
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{id}', [FaqController::class, 'update']);
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);
});

Route::post('/webforms', [WebFormController::class, 'store']);
