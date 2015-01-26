<?php

class Grupo extends Eloquent  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grupos_cli';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $fillable = array('id','nombre');
}
