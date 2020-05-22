<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Produtos;
use App\Models\Reserva;
use App\Models\Telefone;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{

 private $produto;
 private $endereco;
 private $telefone;

 public function __construct(Produtos $produto, Endereco $endereco, Telefone $telefone)
 {
  $this->produto  = $produto;
  $this->endereco = $endereco;
  $this->telefone = $telefone;
  $this->middleware('auth');
 }

 public function index()
 {
  $user = Auth::user();
//   print($user->id);
  //   $produts = $this->produto->where('user_owner', 5)->get();
  //   dd($produts);
  if (Gate::allows('doador-only', auth()->user())) {
   $produtos      = $this->produto->where('userowner_id', $user->id)->get();
   $enderecos     = $this->endereco->where('userowner_id', $user->id)->get();
   $produtosjoint = DB::table('reservas')
    ->join('produtos_reserva', 'produtos_reserva.reserva_id', '=', 'reservas.id')
    ->join('produtos', 'produtos_reserva.produto_id', '=', 'produtos.id')
    ->join('users', 'users.id', '=', 'produtos.userowner_id')
   // ->unique('reservas_id')
    ->get();

   $produtosreservados = $produtosjoint->unique('reserva_id');
   $user               = DB::table('users')
    ->join('reservas', 'reservas.user_id', 'users.id')
    ->get();
   //  dd($produtosreservados);
   return view('user.produtoslista', compact('produtos', 'enderecos', 'produtosreservados', 'user'));
  }
  return redirect('');
 }

 public function quemReservou($id)
 {
  $produtos = DB::table('produtos')
   ->join('produtos_reserva', 'produtos.id', '=', 'produtos_reserva.produto_id')
   ->join('reservas', 'reservas.id', '=', 'produtos_reserva.reserva_id')
   ->get();
  $reserva = Reserva::find($id);
  $user    = DB::table('users')
   ->join('reservas', 'reservas.user_id', 'users.id')
   ->where('reservas.id', $id)
   ->first();
  $contato = DB::table('telefones')->where('userowner_id', $user->user_id)->get();
  // dd($produtos, $reserva, $user);
  // dd($contato);
  return view('user.quemreservoudetalhe', compact('reserva', 'produtos', 'user', 'contato'));
 }
 public function cadastroprodutoform()
 {

  $user = Auth::user();
  if (Gate::allows('doador-only', auth()->user())) {
   $enderecos = $this->endereco->where('userowner_id', $user->id)->get();

   return view('user.cadastrarproduto', compact('enderecos'));
  }
  return redirect('');
 }

 public function inserir(Request $request)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   // $enderecodados = $this->endereco->where('name_place', $request['name_local'])->get();
   //  dd($request->all());
   $validar = Validator::make($request->all(), [
    'id_local'       => ['required', 'numeric'],
    'name_product'   => ['required', 'string'],
    'amount'         => ['required', 'numeric'],
    'datadisponivel' => ['required', 'string', 'date_format:Y-m-d'],
    'horarioinicial' => ['required', 'string', 'date_format:H:i'],
    'horariofinal'   => ['required', 'string', 'date_format:H:i'],
   ])->validate();
   $user = Auth::user();
   $this->produto->create([
    'userowner_id'   => $user->id,
    'id_local'       => $request['id_local'],
    'name_product'   => $request['name_product'],
    'amount'         => $request['amount'],
    'datadisponivel' => $request['datadisponivel'],
    'horarioinicial' => $request['horarioinicial'],
    'horariofinal'   => $request['horariofinal'],
   ]);

   return redirect('');
  }
  return view('home');
 }

 public function listarprodutos()
 {
  if (Gate::allows('beneficiario-only', auth()->user())) {
   $produtos = $this->produto->all();

   $enderecos = $this->endereco->all();
   $telefones = $this->telefone->all();
   //  return view('user.reservarproduto', compact('produtos', 'enderecos'));
   return view('user.reservarproduto')->with([
    'produtos'  => $produtos,
    'enderecos' => $enderecos,
    'telefones' => $telefones,
   ]);
  }
  return view('home');
 }

 public function reservas()
 {
  if (Gate::allows('beneficiario-only', auth()->user())) {
   return view('user.reservas');
  }
  return redirect('');
 }

 public function detalhesproduto($id)
 {
  $produtos  = Produtos::where('id', $id)->firstOrFail();
  $enderecos = $this->endereco->all();

  return view('user.detalhesproduto', compact('produtos', 'enderecos'));
 }
 public function editarprodutoform($id)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $produto = Produtos::find($id);
   // dd($enderecos);
   $enderecos = Endereco::where('userowner_id', $produto->userowner_id)->get();
   return view('user.editarproduto', compact('produto', 'enderecos'));
  }
  return redirect('');
 }
 public function editarproduto(Request $request, $id)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $validar = Validator::make($request->all(), [
    'id_local'       => ['required', 'numeric'],
    'name_product'   => ['required', 'string'],
    'amount'         => ['required', 'numeric'],
    'datadisponivel' => ['required', 'string', 'date_format:Y-m-d'],
    'horarioinicial' => ['required', 'string', 'date_format:H:i'],
    'horariofinal'   => ['required', 'string', 'date_format:H:i'],
   ])->validate();
   Produtos::where('id', $id)->update([
    'id_local'       => $request['id_local'],
    'name_product'   => $request['name_product'],
    'amount'         => $request['amount'],
    'datadisponivel' => $request['datadisponivel'],
    'horarioinicial' => $request['horarioinicial'],
    'horariofinal'   => $request['horariofinal'],
   ]);
   return redirect()->route('produto.lista')->with('success_message', " Os dados do produto foram atualizados com sucesso!");
  }
  return redirect('');
 }
 public function deletarproduto($id)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $prod = $this->produto->find($id)->delete();

   return back()->with('success_message', 'Produto deletado com sucesso.');
  }
  return redirect()->route('inicio');
 }
}
