<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use App\Models\Reserva;
use App\Models\ReservaProduto;
use App\Models\Telefone;
use Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReservaController extends Controller
{
 private $telefone;

 public function __construct(Telefone $telefone)
 {
  $this->telefone = $telefone;
  $this->middleware('auth');
 }

 public function index()
 {

  if (Gate::allows('beneficiario-only', auth()->user())) {
   if (Cart::instance('default')->count() == 0) {
    return redirect()->route('produtos.lista');
   }
   //  // Condição de checagem para quando tem menos itens disponiveis para comprar
   if ($this->produtosNaoEstaoDisponiveis()) {
    return back()->withErrors('Desculpe! Um dos itens do seu carrinho não está disponível.');
   }
   $user = Auth::user();

   $produtos = Produtos::where('userowner_id', $user->id)->get();

   $telefone = $this->telefone->where('userowner_id', $user->id)->where('tipo', 'telefone')->firstOrFail();
   $celular  = $this->telefone->where('userowner_id', $user->id)->where('tipo', 'celular')->firstOrFail();

   // Inserir na tabela de reservas
   $reserva = Reserva::create([
    'user_id' => $user->id,
   ]);

   // Insere na tabela de produtos_reserva
   foreach (Cart::content() as $item) {
    ReservaProduto::create([
     'reserva_id' => $reserva->id,
     'produto_id' => $item->model->id,
     'amount'     => $item->qty,
    ]);
   }

   //  // Reduz a quantidade de todos os itens do carrinho
   $this->reduzirQuantidades();

   Cart::instance('default')->destroy();

   //  $validator = Validator::make($request->all(), [
   //   'user_id'             => ['required', 'integer', 'max:255'],
   //   'business_name'       => ['required', 'string', 'max:255'],
   //   'email'               => ['required', 'string', 'email', 'max:255', 'unique:users'],
   //   'representative_name' => ['required', 'string', 'max:255'],
   //   'cnpj'                => ['required', 'string', 'min:18', 'regex:/^(?!(\d)\1\.\1{3}\.\1{3}\/\1{4}\\-\1{2}$)\d{2}\.\d{3}\.\d{3}\/\d{4}\\-\d{2}$/'],
   //   'telefone'            => ['required', 'string', 'min:14', 'regex:/^\(\d{2}\)\s\d{4}-\d{4}$/'],
   //   'celular'             => ['required', 'string', 'min:15', 'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'],
   //  ]);
   //  return redirect()->route('reserva.concluir')->with([
   //   'success_message' => 'Obrigado! Sua reserva foi realizada!',
   //   'reservadados'    => $reserva,
   //  ]);
   return redirect()->route('inicio')->with('success_message', 'Reserva realizada com sucesso!');
  }
  return redirect()->route('inicio');
 }

 public function reduzirQuantidades()
 {
  foreach (Cart::content() as $item) {

   $produto            = Produtos::find($item->model->id);
   $atualizaquantidade = $produto->amount - $item->qty;
   $produto->where('id', $item->model->id)->update(['amount' => $atualizaquantidade]);
  }
 }

 public function produtosNaoEstaoDisponiveis()
 {
  foreach (Cart::content() as $item) {
   $produto = Produtos::find($item->model->id);
   if ($produto->amount < $item->qty) {
    return true;
   }
  }
  return false;
 }

 public function listarReservas()
 {
  $user     = Auth::user();
  $orders   = Reserva::where('user_id', $user->id)->get(); // fix n + 1 issues
  $produtos = DB::table('produtos')
   ->join('produtos_reserva', 'produtos.id', '=', 'produtos_reserva.produto_id')
   ->join('reservas', 'reservas.id', '=', 'produtos_reserva.reserva_id')
   ->get();
  // foreach ($orders as $order) {
  //  dd($order->id, $produtos);
  // }
  // dd($produtos);
  return view('user.minhasreservas', compact('orders', 'produtos'));
 }
 public function detalhesReserva(Reserva $reserva)
 {
  if (auth()->id() !== $reserva->user_id) {
   return back()->withErrors('Você não tem acesso!');
  }
  // dd($reserva);
  $produtos = DB::table('produtos')
   ->join('produtos_reserva', 'produtos.id', '=', 'produtos_reserva.produto_id')
   ->join('reservas', 'reservas.id', '=', 'produtos_reserva.reserva_id')
   ->get();

  // dd($produtos);
  return view('user.minhasreservasdetalhe', compact('reserva', 'produtos'));
 }
}
