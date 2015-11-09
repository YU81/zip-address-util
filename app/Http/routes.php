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

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->get('address', 'AddressController@index');
$app->get('address/{zip}', 'AddressController@index');
$app->get('address/{zip}/{ken_furi}/', 'AddressController@index');
$app->get('address/{zip}/{ken_furi}/{city_furi}', 'AddressController@index');
$app->get('address/{zip}/{ken_furi}/{city_furi}/{town_furi}', 'AddressController@index');
