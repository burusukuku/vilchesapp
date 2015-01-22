<?php

class Auditoria extends Eloquent {

    protected $table = 'auditoria';

    protected $fillable = array('id_aud', 'usuario', 'dato', 'clase', 'accion');


}