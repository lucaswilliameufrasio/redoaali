<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('produtos', function (Blueprint $table) {
   $table->increments('id');
   $table->integer('userowner_id');
   $table->integer('id_local');
   $table->string('name_product');
   $table->string('amount');
   $table->string('datadisponivel');
   $table->string('horarioinicial');
   $table->string('horariofinal');
   $table->timestamps();

   $table->foreign('id_local')->references('id')->on('enderecos');
   $table->foreign('userowner_id')->references('id')->on('users');
  });
 }

 /**
  * Reverse the migrations.
  *
  * @return void
  */
 public function down()
 {
  Schema::dropIfExists('produtos');
 }
}
