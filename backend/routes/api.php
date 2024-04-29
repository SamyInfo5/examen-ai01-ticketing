<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;

Route::apiResource('role', '\App\Http\Controllers\API\RolesController');
Route::apiResource('user', '\App\Http\Controllers\API\UserController');
Route::post("messages", "\App\Http\Controllers\ChatController@message");

Route::post('register',"\App\Http\Controllers\API\ApiController@register");
Route::post('login',[ApiController::class, 'login']);
Route::group([
    "middleware" => ["auth:sanctum"]
], function() {
    Route::get("profile", "\App\Http\Controllers\API\ApiController@profile");
    Route::get("logout", [ApiController::class, "logout"]);
    Route::apiResource('support', '\App\Http\Controllers\API\SupportsController');
});
