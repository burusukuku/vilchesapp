<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAuditoria extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('auditoria', function($table) {
            $table->increments('id');
            $table->integer('id_aud');
            $table->string('usuario');
            $table->text('dato');
            $table->string('clase');
            $table->string('accion');

            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('auditoria');
	}

}
