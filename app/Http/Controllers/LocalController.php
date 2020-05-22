<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class LocalController extends Controller
{
 /**
  * Create a new controller instance.
  *
  * @return void
  */
 private $endereco;
 public function __construct(Endereco $endereco)
 {
  $this->middleware('auth');
  $this->endereco = $endereco;
 }
 protected function validacao(array $data)
 {
  return Validator::make($data, [
   'name_place'         => ['required', 'string'],
   'endereco-formatado' => ['required', 'string'],
   'type'               => ['required', 'string'],
  ]);
 }
 public function cadastrarlocal(Request $request)
 {
  // dd(request()->all());
  if (Gate::allows('doador-only', auth()->user())) {

   $user = Auth::user();
   $this->validacao($request->all())->validate();

   Endereco::create([
    'name_place'   => $request['name_place'],
    'address'      => $request['endereco-formatado'],
    'type'         => $request['type'],
    'lat'          => $request['lat'],
    'lng'          => $request['lng'],
    'userowner_id' => $user->id,
   ]);
   return redirect()->route('usuario.enderecos')->with('success_message', 'Endereço cadastrado com sucesso!');
  }
  return redirect('');
 }
 public function cadastrolocalform()
 {
  if (Gate::allows('doador-only', auth()->user())) {
   return view('user.cadastrarlocal');
  }
  return redirect('');
 }

 public function editarendereco($id)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $endereco = Endereco::find($id);
   // dd($enderecos);
   return view('user.editarendereco', compact('endereco'));
  }
  return redirect('');
 }
 public function atualizarendereco(Request $request, $id)
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $validar = Validator::make($request->all(), [
    'name_place' => ['required', 'string'],
    'address'    => ['required', 'string'],
    'type'       => ['required', 'string'],
    'lat'        => ['required', 'numeric'],
    'lng'        => ['required', 'string', 'numeric'],
   ])->validate();
   Endereco::where('id', $id)->update([
    'name_place' => $request['name_place'],
    'address'    => $request['endereco-formatado'],
    'type'       => $request['type'],
    'lat'        => $request['lat'],
    'lng'        => $request['lng'],
   ]);
   return redirect()->route('usuario.enderecos')->with('success_message', " Os dados do endereço foram atualizados com sucesso!");
  }
  return redirect('');
 }

 public function deleta($id)
 {
  if (Gate::allows('doador-only', auth()->user()) || Gate::allows('admin-only', auth()->user())) {
   Endereco::find($id)->delete();

   return back()->with('success_message', 'Endereço removido com sucesso.');
  }
 }
 public function enderecosusuario()
 {
  if (Gate::allows('doador-only', auth()->user())) {
   $user      = Auth::user();
   $enderecos = $this->endereco->where('userowner_id', $user->id)->get();

   return view('user.enderecosusuario')->with('enderecos', $enderecos);
  }
  return redirect('');
 }
}
