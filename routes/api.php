<?php

use App\Http\Controllers\Publish\PublishController;
use App\Http\Controllers\Subscription\SubscriptionController;
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
Route::get('/', function () {
    return response()->json([
        'app' => config('app.name'),
        'host' => config('app.url')
    ]);
});

Route::post('/subscribe/{topic}', [SubscriptionController::class, 'subscribe']);
Route::post('/publish/{topic}', [PublishController::class, 'publish']);
