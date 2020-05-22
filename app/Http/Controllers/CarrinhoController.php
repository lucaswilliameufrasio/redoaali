<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Produtos;
use App\Models\Telefone;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CarrinhoController extends Controller
{
 private $endereco;
 private $produto;
 private $telefone;

 public function __construct(Endereco $endereco, Produtos $produto, Telefone $telefone)
 {
  $this->endereco = $endereco;
  $this->produto  = $produto;
  $this->telefone = $telefone;
  $this->middleware('auth');
 }
 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index()
 {
  if (Gate::allows('beneficiario-only', auth()->user())) {
   //  foreach (Cart::content() as $item) {
   //   dd($item->model);
   //  }
   return view('user.carrinho');
  }
  return redirect('');
 }

 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
  //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
  if (Gate::allows('beneficiario-only', auth()->user())) {
//   dd(DB::table('enderecos')->where('userowner_id', $request->userowner_id)->first());
   $duplicado = Cart::search(function ($cartItem, $rowId) use ($request) {
    return $cartItem->id === $request->id;
   });
   if ($duplicado->isNotEmpty()) {
    return redirect()->route('carrinho.index')->with('success_message', 'O item já está no carrinho!');
   }
   Cart::add($request->id, $request->name_product, 1, 0)->associate('App\Models\Produtos');
   return redirect()->route('carrinho.index')->with('sucess_message', 'Item foi adicionado para o carrinho');
  }
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
  //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
  if (Gate::allows('beneficiario-only', auth()->user())) {
   $validator = Validator::make($request->all(), [
    'quantidade' => ['required', 'numeric', 'between: 1, ' . $request->quantidademax],
   ]);
   if ($validator->fails()) {
    session()->flash('errors', collect('Quantidade não pode ser maior que a disponível.'));
    return response()->json(['success' => false], 400);
   }
   Cart::update($id, $request->quantidade);

   session()->flash('success_message', 'A quantidade foi atualizada com sucesso!');
   return response()->json(['success' => true]);
  }
  return redirect('');
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
  Cart::remove($id);

  return back()->with('success_message', 'O Item foi removido');
 }
}
