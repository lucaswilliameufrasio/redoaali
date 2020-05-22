<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\Telefone;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
 /*
 |--------------------------------------------------------------------------
 | Register Controller
 |--------------------------------------------------------------------------
 |
 | This controller handles the registration of new users as well as their
 | validation and creation. By default this controller uses a trait to
 | provide this functionality without requiring any additional code.
 |
  */

 use RegistersUsers;

 /**
  * Where to redirect users after registration.
  *
  * @var string
  */
 private $telefone;
 private $celular;
 private $endereco;
 protected $redirectTo = '/';

 /**
  * Create a new controller instance.
  *
  * @return void
  */
 public function __construct(Telefone $telefone, Endereco $endereco, Telefone $celular)
 {
  $this->middleware('guest');
  $this->telefone = $telefone;
  $this->celular  = $celular;
  $this->endereco = $endereco;
 }

 /**
  * Get a validator for an incoming registration request.
  *
  * @param  array  $data
  * @return \Illuminate\Contracts\Validation\Validator
  */
 public function showRegistrationOption()
 {
  return view('auth.register');
 }

 public function showRegistrationForm(Request $request)
 {
  if ($request->submit == "doador") {
   return view('auth.registerpage', ['permission_access' => 'doador']);
  } else if ($request->submit == "beneficiario") {
   return view('auth.registerpage', ['permission_access' => 'beneficiario']);
  }
 }

 protected function validator(array $data)
 {
  if ($data['permission_access'] == 'doador') {
   return Validator::make($data, [
    'business_name'       => ['required', 'string', 'max:255'],
    'email'               => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
    'password'            => ['required', 'string', 'min:6', 'confirmed'],
    'permission_access'   => ['required', 'string', 'max:20'],
    'representative_name' => ['required', 'string', 'max:255'],
    'cnpj'                => ['required', 'string', 'min:18', 'regex:/^(?!(\d)\1\.\1{3}\.\1{3}\/\1{4}\\-\1{2}$)\d{2}\.\d{3}\.\d{3}\/\d{4}\\-\d{2}$/'],
    'endereco-formatado'  => ['required', 'string'],
    'type'                => ['required', 'string'],
    'telefone'            => ['required', 'string', 'min:14', 'regex:/^\(\d{2}\)\s\d{4}-\d{4}$/'],
    'celular'             => ['required', 'string', 'min:15', 'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'],
    'latitude'            => ['required', 'numeric', 'between: -9999.999999, 9999.999999'],
    'longitude'           => ['required', 'numeric', 'between: -9999.999999, 9999.999999'],
   ]);
  } else {
   return Validator::make($data, [
    'business_name'       => ['required', 'string', 'max:255'],
    'email'               => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/'],
    'password'            => ['required', 'string', 'min:6', 'confirmed'],
    'permission_access'   => ['required', 'string', 'max:20'],
    'representative_name' => ['required', 'string', 'max:255'],
    'cnpj'                => ['required', 'string', 'min:18', 'regex:/^(?!(\d)\1\.\1{3}\.\1{3}\/\1{4}\\-\1{2}$)\d{2}\.\d{3}\.\d{3}\/\d{4}\\-\d{2}$/'],
    'telefone'            => ['required', 'string', 'min:14', 'regex:/^\(\d{2}\)\s\d{4}-\d{4}$/'],
    'celular'             => ['required', 'string', 'min:15', 'regex:/^\(\d{2}\)\s\d{4,5}-\d{4}$/'],
   ]);
  }
 }

 /**
  * Create a new user instance after a valid registration.
  *
  * @param  array  $data
  * @return \App\User
  */
 protected function create(array $data)
 {
  $permissao_acesso = $data['permission_access'];

  if ($permissao_acesso == 'doador') {
   return User::create([
    'business_name'       => $data['business_name'],
    'email'               => $data['email'],
    'password'            => Hash::make($data['password']),
    'permission_access'   => 2,
    'representative_name' => $data['representative_name'],
    'cnpj'                => $data['cnpj'],
    'status'              => 0,
   ]);
  } elseif ($permissao_acesso == 'beneficiario') {
   return User::create([
    'business_name'       => $data['business_name'],
    'email'               => $data['email'],
    'password'            => Hash::make($data['password']),
    'permission_access'   => 3,
    'representative_name' => $data['representative_name'],
    'cnpj'                => $data['cnpj'],
    'status'              => 0,
   ]);
  }
 }

 public function register(Request $request)
 {
  $permissao_acesso = $request['permission_access'];
  $this->validator($request->all())->validate();
  $dadosdecadastro = $request->all();
  event(new Registered($user = $this->create($request->all())));
  if ($permissao_acesso == 'doador') {
   $this->guard()->login($user);
  } elseif ($permissao_acesso == 'beneficiario') {
   $this->guard()->login($user);
  } else {
   return back()->withErrors(['Erro ao concluir o cadastro.']);
  }

  return $this->registered($request, $dadosdecadastro) ?: redirect($this->redirectPath());
 }

 /**
  * Get the guard to be used during registration.
  *
  * @return \Illuminate\Contracts\Auth\StatefulGuard
  */
 protected function guard()
 {
  return Auth::guard();
 }

 /**
  * The user has been registered.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  mixed  $user
  * @return mixed
  */
 protected function registered(Request $request, $user)
 {
  $usuario = Auth::user();
  if ($usuario->permission_access == 2) {
   $this->telefone->create([
    'tipo'         => 'telefone',
    'numero'       => $user['telefone'],
    'userowner_id' => $usuario->id,
   ]);
   $this->celular->create([
    'tipo'         => 'celular',
    'numero'       => $user['celular'],
    'userowner_id' => $usuario->id,
   ]);
   $this->endereco->create([
    'name_place'   => $usuario->business_name,
    'address'      => $user['endereco-formatado'],
    'lat'          => $user['latitude'],
    'lng'          => $user['longitude'],
    'type'         => $user['type'],
    'userowner_id' => $usuario->id,
   ]);
  } else {
   $this->telefone->create([
    'tipo'         => 'telefone',
    'numero'       => $user['telefone'],
    'userowner_id' => $usuario->id,
   ]);
   $this->celular->create([
    'tipo'         => 'celular',
    'numero'       => $user['celular'],
    'userowner_id' => $usuario->id,
   ]);
  }
 }

}
