<?php

class Boletines extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'boletines';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('id','num_boletin', 'ruta','grupo','id_cli_ani','id_cli_exc','enviado');
}
