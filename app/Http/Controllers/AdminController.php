<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct()
 {
  $this->middleware('auth');
 }

 public function privado()
 {
  if (Gate::allows('admin-only', Auth::user())) {
   return view('admin.private');
  }
  // return 'You are not admin!!!!';
  return redirect('');
 }

 public function listarusuarios()
 {
  if (Gate::allows('admin-only', Auth::user())) {
   $users = DB::table('users')->where('permission_access', '!=', 1)->get();

   return view('admin.listadeusuarios', compact('users'));
  }
  return redirect('');
 }

 public function listarprodutos()
 {
  if (Gate::allows('admin-only', Auth::user())) {
   $produtos = DB::table('produtos')->get();

   return view('admin.listadeprodutos', compact('produtos'));
  }
  return redirect('');
 }
 public function atualizarStatus(Request $request, $userid)
 {
  if (Gate::allows('admin-only', Auth::user())) {
   $statusatual = $request['statusconta'];
   if ($statusatual == 0) {
    DB::table('users')->where('id', $userid)->update([
     'status' => 1,
    ]);
    return back()->with('success_message', 'Conta validada com sucesso!');
   } else {
    DB::table('users')->where('id', $userid)->update([
     'status' => 0,
    ]);
    return back()->with('success_message', 'Conta bloqueada com sucesso!');
   }
  }
  return redirect('');
 }

 public function editarProduto($id)
 {
  if (Gate::allows('admin-only', auth()->user())) {
   $produto = Produtos::find($id);
   // dd($enderecos);
   $enderecos = Endereco::where('userowner_id', $produto->userowner_id)->get();
   return view('user.editarproduto', compact('produto', 'enderecos'));
  }
  return redirect('');
 }
 public function concluirEditarProduto($id)
 {
  if (Gate::allows('admin-only', auth()->user())) {
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
   return redirect()->route('admin.listaprodutos')->with('success_message', " Os dados do produto foram atualizados com sucesso!");
  }
  return redirect('');
 }
 public function deletarProduto($id)
 {
  if (Gate::allows('admin-only', auth()->user())) {
   Produtos::find($id)->delete();

   return back()->with('success_message', 'Produto deletado com sucesso.');
  }
  return redirect()->route('inicio');
 }
}
