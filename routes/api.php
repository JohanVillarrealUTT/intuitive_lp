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

Route::group(['as' => 'api.'], function () {
    Route::get('subscriber/get-color-tags-totals', 'Api\V1\SubscriberController@get_color_tags_totals');
    Route::get('subscriber/get-total', 'Api\V1\SubscriberController@get_total');
    Route::get('subscriber/get-by-phone', 'Api\V1\SubscriberController@get_by_phone');
    Route::resource('subscriber', 'Api\V1\SubscriberController', ['except' => ['create', 'edit']]);
    Route::resource('comment', 'Api\V1\CommentController', ['only' => ['store', 'update']]);
    Route::resource('user', 'Api\V1\UserController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);

    Route::post('subscribe', 'Api\V1\SubscriptionController@store');

    Route::post('Subscriber-Vacancy', 'Api\V1\VacancySubscriptionController@store');

    Route::get('available-appointments-list', 'Api\V1\AppointmentController@availableList');

    Route::get('available-appointments', 'Api\V1\AppointmentController@available');

    Route::get('admin/available-appointments', 'Api\V1\AppointmentController@adminAvailable');

    Route::get('search-appointments/{keyword}', 'Api\V1\AppointmentController@searchByKeyword');

    Route::post('change-appointment', 'Api\V1\AppointmentController@changeAppointment');

    Route::post('store-appointment', 'Api\V1\AppointmentController@store');

    Route::put('admin/appointment/{id}', 'Api\V1\AppointmentController@update');

    Route::resource('appointment-dates', 'Api\V1\AppointmentDateController');

    Route::get('admin/configs', 'Admin\AppController@index');
    Route::put('admin/configs', 'Admin\AppController@update');

    Route::resource('label', 'Api\V1\LabelController', ['only' => ['index', 'store', 'update', 'destroy', 'show']]);
});

// \DB::listen(function($query) {
//     \Log::info($query->sql);
//     \Log::info($query->bindings);
//     //var_dump($bindings)
// });
