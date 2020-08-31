<?php
use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Hotel\app\Http\Controllers'], function () {
    Route::prefix('/api/v1/trivago/')->middleware(['Cors', 'Json'])->group(function () {

        Route::get('baseSettings', 'BaseSettingController@all');
        Route::get('baseSetting/{id}', 'BaseSettingController@get');
        Route::post('baseSetting', 'BaseSettingController@set');
        Route::put('baseSetting/{id}', 'BaseSettingController@update');
        Route::delete('baseSetting/{id}', 'BaseSettingController@delete');

        Route::get('settings', 'SettingController@all');
        Route::get('setting/{id}', 'SettingController@get');
        Route::post('setting', 'SettingController@set');
        Route::put('setting/{id}', 'SettingController@update');
        Route::delete('Setting/{id}', 'SettingController@delete');

        Route::get('hotel', 'ItemController@all');
        Route::get('hotel/{id}', 'ItemController@get');
        Route::post('hotel', 'ItemController@set');
        Route::put('hotel', 'ItemController@update');
        Route::delete('hotel/{id}', 'ItemController@delete');


    });
});
