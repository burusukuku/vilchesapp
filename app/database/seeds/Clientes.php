<?php
class CrearClientes extends Seeder {

    public function run()
    {

        DB::table('clientes')->insert(array(
            'nombre' => 'camarero',
            'sueldo' => 110,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ));

        DB::table('categoria')->insert(array(
            'nombre' => 'meitre',
            'sueldo' => 130,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ));

        DB::table('categoria')->insert(array(
            'nombre' => 'cortador',
            'sueldo' => 60,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ));
    }
}