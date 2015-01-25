<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDocumentos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('documentos', function($table)
        {
            $table -> increments('id');

            $table->integer('idcliente');
            $table->string('nombredocumento');
            $table->string('ruta');

            $table->unique(array('ruta', 'idcliente'));

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

        Schema::drop('documentos');
    }

}
