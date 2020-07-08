<?php

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
    return $router->app->version();
});

$router->get('/hello', function () use ($router) {
    $hello = ['message' => 'hello'];

    return json_encode($hello);
});

$router->get('/krs_list', 'KRSController@index');

$router->post('/krs_print', 'KRSController@krs_print');