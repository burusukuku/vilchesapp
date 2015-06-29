<?php

class ConfiguracionController extends BaseController {


    public function index()
    {
        $configuracion =  Configuracion::first();
        return View::make('configuracion.index', array('configuracion' => $configuracion));
    }


    public function editarcorreo()
    {

        
        return View::make('configuracion.editarcorreo', array('configuracion' => $configuracion));
    }

    public function envioprueba()
    {
        
            try{
                $datos=array('email'=>Input::get('correo'), 'nombre'=>'Vilches');
                Mail::send('emails.prueba', $datos, function($message) use ($datos){
                    $message->to( $datos['email'] , $datos['nombre'])->subject('Vilches - Prueba de Envio!');
                });
            }
            catch (\Exception $e) {
                return Redirect::action('configuracion.index')->with('error','No se ha enviado, compruebe su configuración de correo' );
            }
            return Redirect::action('configuracion.index')->with('exito','El correo se ha enviado correctamente' );
    }

    public function actualizarcorreo()
    {

        $rules = array(
            "email" => "required|email",
            "host"=>"required",
            "puerto" => "required",
            "usuario"=>"required",
            "password"=>"required",
            "remitente"=>"required", 
        );




        $messages = array(

            "email.required" => "El campo email es requerido",
            "email.email" => "El correo no tiene un formato adecuado",
            "host.required" => "El campo host es requerido",
            "puerto.required" => "El puerto es requerido",
            "usuario.required" => "El campo usuario es requerido",
            "password.required" => "El campo password es requerido",
            "remitente.required" => "El campo remitente es requerido",
        );



        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

        $configuracion =  Configuracion::first();
        $configuracion->email = Input::get('email');
        $configuracion->host = Input::get('host');
        $configuracion->puerto = Input::get('puerto');
        $configuracion->usuario = Input::get('usuario');
        $configuracion->password = Input::get('password');
        $configuracion->remitente = Input::get('remitente');


        $configuracion->save();

        Event::fire('auditoria', array($configuracion->id, Auth::user()->get()->user, Configuracion::first(), 'configuracion', 'Modificacion'));

        $configuracion =  Configuracion::first();

        return Redirect::action('configuracion.index')->with('exito','La configuracion del correo se ha modificado correctamente' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }   

}



