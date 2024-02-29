<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerificationsController;
use App\Http\Controllers\SetupWhatsController;
use App\Http\Controllers\ListsController;

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

Route::get('/contatos', function () {
    return view('campanhas/contatos');
});

Route::get('/templates', function () {
    return view('campanhas/templates');
});

Route::get('/meus-planos', function () {
    return view('painel/meus-planos');
});



// Users
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::match(['get', 'post'], '/logout', [UsersController::class, 'logout']);

// Verifications
Route::post('/verification', [VerificationsController::class, 'verifyIfEmailAlreadyExist']);

// SetupWhats
Route::get('/setup', [SetupWhatsController::class, 'setup'])->name('setup');
Route::get('/getIdSession', [SetupWhatsController::class, 'getIdSession']);

// Lists
//Route::post('/lists', [ListsController::class, 'store'])->name('lists.store');
Route::post('/criar', [ListsController::class, 'criar'])->name('lists.criar');
Route::post('/update', [ListsController::class, 'update'])->name('lists.update');
Route::post('/getLists', [ListsController::class, 'getLists']);
Route::delete('/delete', [ListsController::class, 'delete']);











