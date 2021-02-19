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
    return $router->app->version();
});
#USER
$router->post('user','UserController@create');
$router->post('login','UserController@login');

#CATEGORY
$router->post('category','CategoryController@create');

#PRODUCT
$router->post('product','ProductController@create');
$router->get('product','ProductController@listProduct');

#ORDER
$router->post('order','OrderController@create');
$router->get('order','OrderController@listOrder');
$router->put('order','OrderController@update');
$router->delete('order','OrderController@delete');

$router->group(['middleware'=>'api'],function () use ($router){
    #USER
    $router->post('logout','UserController@logout');
});