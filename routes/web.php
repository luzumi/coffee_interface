<?php

use Illuminate\Support\Facades\Route;

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
})->name('home');
Route::get('/menu', 'App\Http\Controllers\MenuController@show')->name('menu');


//Route::post('/webhook', 'App\Http\Controllers\WebhookController@handleWebhook')->name('webhook');
Route::post('/turn_on', 'App\Http\Controllers\TurnRelaisOn@sendStripeWebhook')->name('turn_on');


Route::group(['middleware' => ['web']], function () {
    Route::post('/webhook', 'App\Http\Controllers\WebhookController@handleWebhook')
        ->withoutMiddleware(['csrf'])
        ->middleware('web');
});
Route::get('/webhook_data', 'App\Http\Controllers\WebhookController@getWebhookData')->name('webhook_data');
Route::post('/welcome', 'App\Http\Controllers\MenuController@backToWelcome')->name('back_to_welcome');
