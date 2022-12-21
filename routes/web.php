<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view("welcome");
})->name("welcome");

Route::get('/dashboard', function () {
    return view("app");
})->name("dashboard");

Route::prefix('estoque')->group(function () {
    Route::get('/', 'App\Http\Controllers\FunctionsController@index')->name("estoque");
    Route::get("/produto", "App\Http\Controllers\FunctionsController@index")->name("estoque.produto");
});

Route::prefix('nota-fiscal')->group(function () {    
    Route::resource("controle-de-nfs", App\Http\Controllers\ControleDeNFController::class);

    Route::resource("controle-de-imposto", App\Http\Controllers\ControleDeImpostoController::class);
});

Route::resource('nota-fiscal', App\Http\Controllers\NotaFiscalController::class); //('/', 'App\Http\Controllers\FunctionsController@index')->name("notas-fiscais");

Route::get('configuracoes/alterar-funcionario', function () {
    return view('settings.alterar-funcionario');
})->name('configuracoes.alterar-funcionario');

Route::resource('configuracoes', App\Http\Controllers\ConfiguracoesController::class);

// Route::get('/cadastro', function () {
//     return view("autenticacao.cadastro-empresa");
// });
Route::resource("login", App\Http\Controllers\LoginController::class);

Route::get('logout', 'App\Http\Controllers\FunctionsController@deslogarSessaoEmpresa')->name("logout");

// Route::get('/login', function () {
//     return view("autenticacao.login-empresa");
// })->name("login");

// Route::get('/nota-fiscal', function () {
//     return view("app");
// })->name('notas-fiscais');
// Route::get('/nota-fiscal/controle-de-nfs', function () {
//     return view("app");
// })->name('controle-de-nfs');

// Route::match(['get', 'post'], '/user/profile', function () {
// });


















// Route::get('/estoque/produto/modal-largo',  [App\Http\Controllers\Functions::class, 'solicita_criação_conteudo_modal_largo']);

// Route::get('/estoque/produto/modal-largo', function () {
//     return "Funcionando!!!";
// });
// [...]
