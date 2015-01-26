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
    protected $fillable = array('cif','empresa','nombre', 'apell1', 'apell2', 'direccion', 'telefono', 'email','localidad','grupo','observaciones');
}
