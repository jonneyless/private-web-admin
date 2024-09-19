<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index');

    $router->resource('from', FromController::class);
    $router->get('fromback/{id}', 'FromController@fromback');
    
    $router->resource('user', UserController::class);
    $router->resource('reply', ReplyController::class);
    $router->resource('msg', QuickController::class);
    $router->resource('autoreply', AutoReplyController::class);
    $router->resource('business', BusinessController::class);
    $router->resource('businessIntro', BusinessIntroController::class);
    $router->resource('allowip', AllowIpController::class);
    
    $router->post('user/changeFlag', 'UserController@changeFlag');
    
    Route::group(["prefix" => "config"], function (Router $router) {
        Route::get("/", "ConfigController@index");
        Route::post("change", "ConfigController@change");
    });
    
    $router->post('from/changeFlag', 'FromController@changeFlag');
    $router->post('from/changeStatus', 'FromController@changeStatus');
    
    $router->resource('evaluate', EvaluateController::class);

    $router->get('jieba', "JiebaController@index");
    Route::post("jieba/data", "JiebaController@data");

    $router->resource('officalkefu', OfficalKefuController::class);
});
