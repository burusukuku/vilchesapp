<?php

class Contactos extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contactos_cli';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('id','id_cli','nombre','apell1','apell2','telefono','email','direccion','localidad');
}
