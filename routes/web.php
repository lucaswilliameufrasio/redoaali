<?php

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
use Gloudemans\Shoppingcart\Facades\Cart;

Route::get('/', ['uses' => 'HomeController@index'])->name('inicio');
Auth::routes(['register' => false]);
/*Rota dos administradores do sistema*/
Route::get('/private', 'AdminController@privado')->name('private');
Route::get('/admin/listausuarios', 'AdminController@listarusuarios')->name('admin.listausuarios');
Route::patch('/admin/listausuarios/{usuarioid}', 'AdminController@atualizarStatus')->name('admin.atualizastatus');
Route::get('/admin/listaprodutos', 'AdminController@listarprodutos')->name('admin.listaprodutos');
Route::get('/admin/listaprodutos/{produto}', 'AdminController@editarProduto')->name('admin.editarproduto');
Route::patch('/admin/listaprodutos/{produto}', 'AdminController@concluirEditarProduto')->name('admin.concluieditarproduto');
Route::delete('/admin/listaprodutos/{produto}', 'AdminController@deletarProduto')->name('admin.deletaproduto');

/* Rota de cadastro de produtos */
Route::get('/cadastrarprodutos', [
 'as'   => '/cadastrarprodutos',
 'uses' => 'ProdutosController@cadastroprodutoform',
]);
Route::post('/cadastrarprodutos', [
 'as'   => '',
 'uses' => 'ProdutosController@inserir',
]);

/* Rota de listagem de produtos do usuário doador */
Route::get('/produtos', 'ProdutosController@index')->name('produto.lista');
Route::get('/quemreservou/{produtos}', 'ProdutosController@quemReservou')->name('produto.quemreservou');
/* Rotas para edição dos dados do produto */
Route::get('/produtos/{produtos}', 'ProdutosController@editarprodutoform')->name('produto.editarprodutoform');
Route::patch('/produtos/{produtos}', 'ProdutosController@editarproduto')->name('produto.editarproduto');
Route::delete('/deletarproduto/{produtos}', 'ProdutosController@deletarproduto')->name('produto.deleta');
/* Rota para a página sobre o projeto */
Route::get('/sobre', 'HomeController@sobre')->name('sobre');
/* Rotas para cadastro dos usuários*/
Route::get('/cadastrar-opcao', [
 'as'   => '/cadastrar-opcao',
 'uses' => 'Auth\RegisterController@showRegistrationOption',
]);
Route::get('/cadastrar', [
 'as'   => '/cadastrar',
 'uses' => 'Auth\RegisterController@showRegistrationForm',
]);
Route::post('/cadastrar', [
 'as'   => '',
 'uses' => 'Auth\RegisterController@register',
]);
/* Rota para listagem de todos os produtos disponiveis - beneficiario */
Route::get('/produtosdisponiveis', 'ProdutosController@listarprodutos')->name('produtos.lista');
/* Rota para detalhes do produto - beneficiario*/
Route::get('/produtosdisponiveis/{id}', 'ProdutosController@detalhesproduto')->name('produto.detalhe');
/* Rota para listagem das reservas realizadas */
// Route::get('/minhasreservas', 'ProdutosController@reservas');
/* Rotas para o carrinho de compras */
Route::get('/carrinho', 'CarrinhoController@index')->name('carrinho.index');
Route::post('/carrinho', 'CarrinhoController@store')->name('carrinho.store');
Route::patch('/carrinho/{produtos}', 'CarrinhoController@update')->name('carrinho.atualizaqtd');
Route::delete('/carrinho/{produtos}', 'CarrinhoController@destroy')->name('carrinho.deleta');
//Rota para esvaziar o carrinho
Route::get('esvaziar', function () {
 Cart::destroy();
 return redirect()->route('carrinho.index');

})->name('limparcarrinho');

/* Rota para conclusão da reserva */
Route::get('/concluirreserva', 'ReservaController@index')->name('reserva.concluir');
// Route::get('/confirmacao', 'ReservaController@confirmacao')->name('reserva.concluir');
/* Rota para perfil do usuário */
Route::get('/perfil', 'UserController@index')->name('usuario.perfil');
/* Rota para edição dos dados do usuário */
// Route::put('/editardados/{usuario}', 'UserController@edit')->name('usuario.editar');
Route::patch('/perfil/{usuario}', 'UserController@update')->name('usuario.editar');
/* Rota para endereços cadastrados */
Route::get('/enderecos', 'LocalController@enderecosusuario')->name('usuario.enderecos');
Route::get('/enderecos/{endereco}', 'LocalController@editarendereco')->name('endereco.editar');
Route::patch('/enderecos/{endereco}', 'LocalController@atualizarendereco')->name('endereco.concluireditar');
Route::delete('/enderecos/{produtos}', 'LocalController@deleta')->name('endereco.deleta');
/* Rota de cadastro de local */
Route::get('/cadastrarlocal', ['uses' => 'LocalController@cadastrolocalform'])->name('cadastrolocalform');
Route::post('/cadastrarlocal', 'LocalController@cadastrarlocal')->name('cadastrarlocal');
/*Rota para listagem de reservas - beneficiario */
Route::get('/minhasreservas', 'ReservaController@listarReservas')->name('reserva.lista');
Route::get('/minhasreservas/{reserva}', 'ReservaController@detalhesReserva')->name('reserva.detalhe');
