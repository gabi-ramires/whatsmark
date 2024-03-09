<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VerificationsController;
use App\Http\Controllers\SetupWhatsController;
use App\Http\Controllers\ListsController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\EnvioController;
use App\Http\Controllers\ExtratoEnvioController;
use App\Http\Controllers\PlanoController;

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

Route::get('/nova-campanha', function () {
    return view('campanhas/nova-campanha');
});

Route::get('/dashboard', function () {
    return view('campanhas/dashboard');
});

Route::get('/meus-planos', function () {
    return view('painel/meus-planos');
});

Route::get('/conta', function () {
    return view('painel/conta');
});



// Users
Route::post('/register', [UsersController::class, 'register']);
Route::post('/login', [UsersController::class, 'login']);
Route::match(['get', 'post'], '/logout', [UsersController::class, 'logout']);
Route::post('/password', [UsersController::class, 'updatePassword']);


// Verifications
Route::post('/verification', [VerificationsController::class, 'verifyIfEmailAlreadyExist']);

// SetupWhats
Route::get('/setup', [SetupWhatsController::class, 'setup'])->name('setup');
Route::get('/getIdSession', [SetupWhatsController::class, 'getIdSession']);

// Lists
Route::post('/criar', [ListsController::class, 'criar'])->name('lists.criar');
Route::post('/update', [ListsController::class, 'update'])->name('lists.update');
Route::post('/getLists', [ListsController::class, 'getLists']);
Route::delete('/delete', [ListsController::class, 'delete']);

//Cron
Route::post('/executar-cron', [CronController::class, 'cron']);

//Envios
Route::post('/storeEnvios', [EnvioController::class, 'storeEnvios']);
Route::get('/getTodosEnvios', [EnvioController::class, 'getTodosEnvios']);

//ExtratoEnvios
Route::post('/storeExtratoEnvios', [ExtratoEnvioController::class, 'storeExtratoEnvios']);
Route::get('/getSaldo', [ExtratoEnvioController::class, 'getSaldo']);
Route::get('/getLimite', [ExtratoEnvioController::class, 'getLimite']);

//Plano
Route::get('/verificaSeTemPlano/{sessionId}', [PlanoController::class, 'verificaSeTemPlano']);














