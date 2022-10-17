<?php

use App\Http\Controllers\ToDoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('todos',[ToDoController::class,'index']);
Route::post('todos',[ToDoController::class,'store']);
Route::delete('todos/{id}',[ToDoController::class,'destroy']);
Route::put('todos/{id}',[ToDoController::class,'update']);
Route::put('complete-todo',[ToDoController::class,'complete']);
Route::put('incomplete-todo',[ToDoController::class,'incomplete']);

