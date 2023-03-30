<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CacheHeaders;
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

Route::middleware([CacheHeaders::class])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
    Route::get('/menu', 'App\Http\Controllers\MenuController@show')->name('menu');

    Route::post('/turn_on', 'App\Services\WebhookService@sendWebhookGetCoffee')->name('get_coffee');

    Route::post('/webhook', 'App\Services\WebhookService@handleWebhook')->name('webhook');
    Route::get('/webhook_data', 'App\Services\WebhookService@getWebhookData')->name('webhook_data');
    Route::post('/welcome', 'App\Http\Controllers\MenuController@backToWelcome')->name('back_to_welcome');
    Route::post('/new_order/{type}', 'App\Http\Controllers\CoffeeOrdersController@newOrder')->name('new_order');
    Route::get('/in_progress', 'App\Http\Controllers\MenuController@inProgress')->name('in_progress');
    Route::get('/logout', 'App\Http\Controllers\MenuController@logout')->name('logout');
    Route::get('/user_not_found', 'App\Http\Controllers\MenuController@userNotFound')->name('user_not_found');
    Route::get('/need_service', 'App\Http\Controllers\MenuController@needService')->name('need_service');
    Route::get('/disruption', 'App\Http\Controllers\MenuController@disruption')->name('disruption');

    Route::get('/set', 'App\Services\WebhookService@setId')->name('setId');
});


Route::get('/test', 'App\Http\Controllers\MenuController@test')->name('test');
