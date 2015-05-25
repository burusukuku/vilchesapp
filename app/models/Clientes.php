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
    protected $fillable = array('id', 'cif','empresa','telefono','direccion','localidad','grupo','observaciones');
}
