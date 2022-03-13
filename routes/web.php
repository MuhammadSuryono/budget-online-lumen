<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return response()->json([
        "status" => "success",
        "message" => "Welcome to the API",
        "app_version" => "1.0.0",
        "app_name" => "Budget Online Api",
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router)
{
    // Auth
    $router->group(['prefix' => 'auth'], function () use ($router)
    {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh-token', 'AuthController@refresh_token');
    });

});