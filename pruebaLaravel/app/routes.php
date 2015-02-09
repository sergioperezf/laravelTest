<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*
 * login route
 */
Route::any("/", [
 "as"   => "user/login",
 "uses" => "UserController@login"
]);

Route::any("/profile", [
  "as"   => "user/profile",
  "uses" => "UserController@profile"
]);
Route::any("/edit", [
  "as"   => "user/edit",
  "uses" => "UserController@edit"
]);
Route::any("/logout", [
  "as"   => "user/logout",
  "uses" => "UserController@logout"
]);
Route::post("/uploadimage", [
  "as"   => "picture/upload",
  "uses" => "PictureController@upload"
]);
Route::post("/deleteimage", [
  "as"   => "picture/delete",
  "uses" => "PictureController@delete"
]);