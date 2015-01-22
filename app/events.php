<?php

Event::listen('auditoria', function($id_aud, $usuario, $dato, $clase, $accion) {
    Auditoria::create(array('id_aud'=> $id_aud, 'usuario'=>$usuario, 'dato'=>$dato, 'clase'=>$clase, 'accion'=>$accion));
});