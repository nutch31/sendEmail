<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/index', 'SendDailyEmailController@index');
Route::post('/sendEmail', 'SendDailyEmailController@sendEmail');
Route::post('/notificationEmail', 'NotificationEmailController@notificationEmail');
Route::post('/summarizeNotificationEmail', 'SummarizeNotificationEmailController@summarizeNotificationEmail');
Route::post('/verifyLeadsEveryCampaignEmail', 'VerifyLeadsEveryCampaignEmailController@verifyLeadsEveryCampaignEmail');
Route::post('/resetPassword', 'AlphaController@resetPassword');

Route::get('createGoogleSheet', 'CreateGoogleSheetController@createGoogleSheet');
