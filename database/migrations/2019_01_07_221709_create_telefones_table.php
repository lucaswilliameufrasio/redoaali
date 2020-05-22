<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonesTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::create('telefones', function (Blueprint $table) {
   $table->increments('id');
   $table->string('tipo');
   $table->string('numero');
   $table->integer('userowner_id');
   $table->timestamps();
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
  Schema::dropIfExists('telefones');
 }
}
