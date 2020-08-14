<?php

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

Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {

    Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function () {
        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')->name('captchas.store');

        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');

        // 用户注册
        Route::post('users', 'UsersController@store')->name('users.store');

        // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('social_type', 'wechat|weibo')
            ->name('socials.authorizations.store');

        // 登录
        Route::post('authorizations', 'AuthorizationsController@store')
            ->name('api.authorizations.store');

        // 刷新token
        Route::put('authorizations/current', 'AuthorizationsController@update')
            ->name('authorizations.update');
        // 删除token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')
            ->name('authorizations.destroy');
    });

    Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
        // 某个用户的详情
        Route::get('users/{user}', 'UsersController@show')->name('users.show');

        // 登录后可以访问的接口
        Route::middleware('auth:api')->group(function () {
            // 当前登录用户信息
            Route::get('user', 'UsersController@me')->name('user.show');
        });
    });
});
