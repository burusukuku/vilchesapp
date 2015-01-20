<?php

class ClientesController extends BaseController {



    public function crear()
    {
        return View::make('Clientes.crear');
    }

    public function guardar()
    {
        $rules = array(
            "nombre" => "required",
            "dni" => "required|unique:clientes,dni",
            "apell1" => "required",
            "apell2" => "required",
            "fecha_nac" => "required",
            "telefono" => "required",
            "direccion" => "required",
            "localidad" => "required",
        );

        $messages = array(
            "dni.required" => "El campo dni es requerido",
            "dni.unique" => "El campo dni ya existe en la base de datos",
            "nombre.required" => "El campo nombre es requerido",
            "apell1.required" => "El campo 1º apellido es requerido",
            "apell2.required" => "El campo 2º apellido es requerido",
            "telefono.required" => "El campo telefono es requerido",
            "fecha_nac.required" => "El campo fecha de nacimiento es requerido",
            "direccion.required" => "El campo direccion es requerido",
            "localidad.required" => "El campo localidad es requerido",
        );

        $validator = Validator::make(Input::All(), $rules, $messages);
        if($validator->passes()) {
            $carta = Carta::create(array(
                'nombre' => Input::get('nombre'),
                'dni' => Input::get('dni'),
                'apell1' => Input::get('apell1'),
                'apell2' => Input::get('apell2'),
                'telefono' => Input::get('telefono'),
                'fecha_nac' => Input::get('fecha_nac'),
                'direccion' => Input::get('direccion'),
                'localidad' => Input::get('localidad'),
            ));

            $carta=Carta::all();
            Event::fire('auditoria', array($carta->last()->id, Auth::user()->get()->user,$carta->last(), 'Carta', 'Alta'));
            return Redirect::action('ClientesController@index');
        }else{
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }
}
