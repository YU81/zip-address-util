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

$app->get('api/address', 'AddressController@get');
$app->get('api/address/{zip}', 'AddressController@get');
$app->get('api/address/{zip}/{ken_furi}/', 'AddressController@get');
$app->get('api/address/{zip}/{ken_furi}/{city_furi}', 'AddressController@get');
$app->get('api/address/{zip}/{ken_furi}/{city_furi}/{town_furi}', 'AddressController@get');

$app->get('/', 'AddressController@index');
$app->get('/address', 'AddressController@index');
$app->get('/address/result', 'AddressController@searchResult');