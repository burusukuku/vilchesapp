<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClientes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('clientes', function($table)
        {
            $table -> increments('id');

            $table->string('dni');
            $table->string('nombre');
            $table->string('apell1');
            $table->string('apell2');
            $table->string('telefono');
            $table->string('email');
            $table->string('direccion');
            $table->string('localidad');
            $table->date('fecha_nac');

            $table->unique(array('dni'));

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

        Schema::drop('clientes');
    }

}
