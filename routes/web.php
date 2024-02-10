<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// SITE
Route::get('/', function () {
    return view('site/index');
});


Route::get('/sobre', function () {
    return view('site/sobre');
});

Route::get('/login', function () {
    return view('site/login');
});

Route::get('/cadastro', function () {
    return view('site/cadastro');
});


// PAINEL
Route::get('/painel', function () {
    return view('painel/painel');
});

Route::get('/tutorial', function () {
    return view('painel/tutorial');
});

Route::get('/campanhas', function () {
    return view('campanhas/index');
});



// métodos
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);





