<?php
use Carbon\Carbon;

class EmpresaController extends BaseController {


    public function index()
    {
        $empresa =  Empresa::first();
        return View::make('empresa.index', array('empresa' => $empresa));
    }


    public function editar()
    {

        $empresa =  Empresa::first();
        return View::make('empresa.editar', array('empresa' => $empresa));
    }


    public function actualizar()
    {
        $id = Input::get('id');

        if(Input::file("foto")!=""){
            $file=Input::file("foto");
            $nombre=$file->getClientOriginalName();
            $file->move("fotos/empresa/",$file->getClientOriginalName());
         }

        $rules = array(
            "cif" => "required",
            "nombre"=>"required",
            "email" => "required|email",
            "direccion"=>"required",
            "localidad"=>"required",
            "provincia"=>"required",
            "cp"=>"required",
            "telefono" => "required",
        );




        $messages = array(

            "cif.required" => "El campo cif es requerido",
            "nombre.required" => "El campo nombre es requerido",
            "email.required" => "El correo es requerido",
            "email.email" => "El correo no tiene un formato adecuado",
            "direccion.required" => "El campo direccion es requerido",
            "localidad.required" => "El campo localidad es requerido",
            "provincia.required" => "El campo provincia es requerido",
            "cp.required" => "El campo cp es requerido",
            "telefono.required" => "El campo telefono es requerido",
        );



        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

        $empresa =  Empresa::first();
        $empresa->cif = Input::get('cif');
        $empresa->nombre = Input::get('nombre');
        $empresa->email = Input::get('email');
        $empresa->direccion = Input::get('direccion');
        $empresa->localidad = Input::get('localidad');
        $empresa->provincia = Input::get('provincia');
        $empresa->cp = Input::get('cp');
        $empresa->telefono = Input::get('telefono');
        $empresa->logo = $nombre;


        $empresa->save();

        Event::fire('auditoria', array($empresa->id, Auth::user()->get()->user, Empresa::first(), 'empresa', 'Modificacion'));

        $empresa =  Empresa::first();

        return Redirect::action('empresa.index')->with('exito','La Empresa se ha modificado correctamente' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }   


}



