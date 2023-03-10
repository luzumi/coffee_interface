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


Route::post('/turn_on', 'App\Services\WebhookService@sendWebhookGetCoffee')->name('get_coffee');


//Route::get('/get-csrf-token', function () {
//    return response()->json(['X-CSRF-TOKEN' => csrf_token()]);
//})->withoutMiddleware(['csrf']);

Route::post('/webhook', 'App\Services\WebhookService@handleWebhook')->name('webhook');
//Route::group(['middleware' => ['web']], function () {
//    Route::post('/webhook', 'App\Services\WebhookService@handleWebhook')
//        ->withoutMiddleware(['csrf'])
//        ->middleware('web')
//        ->name('webhook');
//});

//Route::post('/webhook', 'App\Http\Controllers\WebhookController@handleWebhook')->middleware('verifyWebhook');
//Route::post('/webhook', 'App\Services\WebhookService@handleWebhook')
//    ->middleware('verify.webhook')
//    ->name('verify_webhook');



Route::get('/webhook_data', 'App\Services\WebhookService@getWebhookData')->name('webhook_data');
Route::post('/welcome', 'App\Http\Controllers\MenuController@backToWelcome')->name('back_to_welcome');
//Route::get('/limit/{key}', 'App\Http\Controllers\MenuController@limit')->name('limit');
Route::post('/new_order/{type}', 'App\Http\Controllers\CoffeeOrdersController@newOrder')->name('new_order');
Route::get('/in_progress', 'App\Http\Controllers\MenuController@inProgress')->name('in_progress');
Route::get('/logout', 'App\Http\Controllers\MenuController@logout')->name('logout');

Route::get('/set', 'App\Services\WebhookService@setId')->name('setId');
