<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
 /**
  * Seed the application's database.
  *
  * @return void
  */
 public function run()
 {
  DB::table('users')->insert([
   'business_name'       => 'administrador',
   'representative_name' => 'administrador',
   'permission_access'   => 1,
   'cnpj'                => 'xxxxxxxxxxxxxxxxxxxx',
   'email'               => 'administrador@admin.com',
   'password'            => bcrypt('1234567'),
   'status'              => 1,
  ]);

//    DB::table('produtos')->insert([
  //     'user_owner' => '2',
  //     'name_local' => 'Supermercado teste',
  //     'name_product' => 'Maçã',
  //     'amount' => 10,
  // ]);
 }
}
