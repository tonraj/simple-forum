<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, "index"]);
Route::get('/suggestion', [HomeController::class, "suggestion"]);
Route::get('/sitemap.xml', [HomeController::class, "sitemap"]);
Route::match(['get', 'post'], '/ask_question', [QuestionController::class, "ask_question"]);
Route::get('/category/{slug}/{id}', [QuestionController::class, "category_result"]);
Route::match(['get', 'post'], '/question/{id}-{slug}', [QuestionController::class, "view_question"])->name("view_question_route");

Route::get('/search/', function () {
    return view('searchresult');
});


