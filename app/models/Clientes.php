<?php

class Clientes extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clientes';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('nombre', 'dni', 'apell1', 'apell2', 'direccion', 'telefono', 'email','localidad','fecha_nac');
}
