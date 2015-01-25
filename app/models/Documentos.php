<?php

class Documentos extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documentos';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('idcliente','nombredocumento', 'ruta');
}
