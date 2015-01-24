<?php
use Carbon\Carbon;

class ClientesController extends BaseController {


    public function index()
    {
        $paginacion = Clientes::orderBy('apell1')->get();
        return View::make('clientes.index', array('paginacion' => $paginacion));
    }

    public function crear()
    {
        return View::make('Clientes.crear');
    }

    public function mostrar($id)
    {

        $clientes =  Clientes::find($id);
        $documentos = Documentos::all();
        return View::make('clientes.mostrar', array('clientes' => $clientes, 'documentos' => $documentos));
    }
    
    public function guardar()
    {
        $rules = array(
            "nombre" => "required",
            "dni" => "required|unique:clientes,dni",
            "apell1" => "required",
            "apell2" => "required",
            "fecha_nac" => "required",
            "email" => "required",
            "telefono" => "required",
            "direccion" => "required",
            "localidad" => "required",
        );

        $messages = array(
            "dni.required" => "El campo dni es requerido",
            "dni.unique" => "El campo dni ya existe en la base de datos",
            "nombre.required" => "El campo nombre del documento es requerido",
            "apell1.required" => "El campo 1º apellido es requerido",
            "apell2.required" => "El campo 2º apellido es requerido",
            "telefono.required" => "El campo telefono es requerido",
            "email.required" => "El campo email es requerido",
            "fecha_nac.required" => "El campo fecha de nacimiento es requerido",
            "direccion.required" => "El campo direccion es requerido",
            "localidad.required" => "El campo localidad es requerido",
        );

        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

            $fecha = Carbon::createFromFormat('d/m/Y', Input::get('fecha_nac'));
            $fecha_nac = $fecha->toDateString();

            $clientes = Clientes::create(array(
                'nombre' => Input::get('nombre'),
                'dni' => Input::get('dni'),
                'apell1' => Input::get('apell1'),
                'apell2' => Input::get('apell2'),
                'telefono' => Input::get('telefono'),
                'email' => Input::get('email'),
                'fecha_nac' => $fecha_nac,
                'direccion' => Input::get('direccion'),
                'localidad' => Input::get('localidad'),
            ));

            $clientes = Clientes::all();
            Event::fire('auditoria', array($clientes->last()->id, Auth::user()->get()->user, $clientes->last(), 'Clientes', 'Alta'));
            return Redirect::action('ClientesController@index');
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }

    public function subirdocumento()
    {
        $ruta = Input::file("documento")->getClientOriginalName();

        $rules = array(
            "nombredocumento" => "required",
            "documento" => "required|unique:documentos,ruta",
        );

        $messages = array(
            "nombredocumento.required" => "El campo nombre es requerido",
            "documento.required" => "El campo documento es requerido",
        );

        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {
            $id = Input::get("id");
            $file = Input::file("documento");

            $documentos = Documentos::create(array(
                'idcliente' => Input::get('id'),
                'nombredocumento' => Input::get('nombredocumento'),
                'ruta' => $ruta,
            ));

            $file->move("documentos/" . $id, $file->getClientOriginalName());
            $documentos = Documentos::all();
            Event::fire('auditoria', array($documentos->last()->id, Auth::user()->get()->user, $documentos->last(), 'Documentos', 'Alta'));
            return Redirect::action('ClientesController@mostrar', array('id' => $id));
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }

        public function eliminardocumento($id)
    {
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Documentos::find($id), 'Documentos', 'Baja'));
        $documento=Documentos::find($id);
        $idcliente=$documento->idcliente;
        Documentos::find($id)->delete();
        File::delete('documentos/'.$idcliente.'/'.$documento->ruta);
        return Redirect::action('ClientesController@mostrar',array('id' => $idcliente));
    }

    }



