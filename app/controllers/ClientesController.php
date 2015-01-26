<?php
use Carbon\Carbon;

class ClientesController extends BaseController {


    public function index()
    {
        $paginacion = Clientes::orderBy('empresa')->get();
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

    public function editar($id)
    {

        $clientes =  Clientes::find($id);
        return View::make('clientes.editar', array('clientes' => $clientes));
    }

    public function guardar()
    {
        $grupo=Input::get('grupo');
        if($grupo=='*') //Cuando se quiere añadir a un grupo que se está creando en ese momento.
        {
            $rules = array(
                "cif" => "unique:clientes,cif",
                "empresa" => "required|unique:clientes,empresa",
                "nuevogrupo"=>"required|unique:grupos_cli,nombre"
            );
        }else{
            $rules = array(
                "cif" => "unique:clientes,cif",
                "empresa" => "required|unique:clientes,empresa",
            );
        }



        $messages = array(

            "cif.unique" => "El campo cif ya existe en la base de datos",
            "empresa.required" => "El campo empresa es requerido",
            "empresa.unique" => "La empresa ya existe en la base de datos",
            "nuevogrupo.required" => "El nombre del nuevo grupo es requerido",
            "nuevogrupo.unique" => "El grupo ya existe en la base de datos",
        );

        $confirmacion = array(
            "ok" => "El Cliente ha sido guardado con exito");

        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {


            if(is_numeric ($grupo)==false && $grupo<>0){
                Grupo::create(array('nombre'=>Input::get('nuevogrupo')));
                $grupo=Grupo::all()->last()->id;
            }

            $clientes = Clientes::create(array(
                'cif' => Input::get('cif'),
                'empresa' => Input::get('empresa'),
                'nombre' => Input::get('nombre'),
                'apell1' => Input::get('apell1'),
                'apell2' => Input::get('apell2'),
                'telefono' => Input::get('telefono'),
                'email' => Input::get('email'),
                'direccion' => Input::get('direccion'),
                'localidad' => Input::get('localidad'),
                'grupo' => $grupo,
                'observaciones' => Input::get('observaciones'),
            ));


            $clientes = Clientes::all();
            Event::fire('auditoria', array($clientes->last()->id, Auth::user()->get()->user, $clientes->last(), 'Clientes', 'Alta'));
            return Redirect::action('ClientesController@index')->withinput()->withErrors($confirmacion);
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }

    public function actualizar()
    {
        $id = Input::get('id');
        $clientes =  Clientes::find($id);
        $clientes->cif = Input::get('cif');
        $clientes->empresa = Input::get('empresa');
        $clientes->nombre = Input::get('nombre');
        $clientes->apell1 = Input::get('apell1');
        $clientes->apell2 = Input::get('apell2');
        $clientes->direccion = Input::get('direccion');
        $clientes->localidad = Input::get('localidad');
        $clientes->telefono = Input::get('telefono');
        $clientes->email = Input::get('email');
        $clientes->grupo = Input::get('grupo');

        $clientes->save();

        Event::fire('auditoria', array($id, Auth::user()->get()->user, Clientes::find($id), 'Clientes', 'Modificacion'));
        $mensaje = 'Perfecto cliente modificado correctamente.';
        $clientes =  Clientes::find($id);
        $documentos = Documentos::all();
        return View::make('clientes.mostrar', array('clientes' => $clientes, 'documentos' => $documentos, 'mensaje'=>$mensaje));
    }

    public function subirdocumento()
    {
        if(Input::file("documento")==NULL){
            $ruta=NULL;
        }else{
            $ruta = Input::file("documento")->getClientOriginalName();
        }
        $id = Input::get("id");

        $rules = array(
            "nombredocumento" => "required",
            "documento" => "required|unique:documentos,ruta,NULL,id,idcliente,".$id."",
        );

        $messages = array(
            "nombredocumento.required" => "El campo nombre del documento es requerido",
            "documento.required" => "El archivo a subir es requerido",
            "documento.unique" => "El archivo ya existe en la base de datos",
        );



        $validator = Validator::make( array('nombredocumento'=> Input::get('nombredocumento'),'documento'=> $ruta ), $rules, $messages);
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
            return Redirect::action('ClientesController@mostrar', array('id' => $id))->with('exito','El archivo se ha subido con éxito' );
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
        return Redirect::action('ClientesController@mostrar',array('id' => $idcliente))->with('error','El archivo ha sido eliminado permanentemente' );
    }

    public function eliminar($id)
    {
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Clientes::find($id), 'Clientes', 'Baja'));
        $documentos=Documentos::where('idcliente','=',$id)->get();
        foreach($documentos as $documento)
        {
                Event::fire('auditoria', array(($documento->id), Auth::user()->get()->user, Documentos::find($documento->id), 'Documentos', 'Baja'));
                Documentos::find($documento->id)->delete();
        }

        File::deleteDirectory("documentos/".$id);
        Clientes::find($id)->delete();

        return Redirect::action('ClientesController@index');
    }

    public function descargar($id){
        //PDF file is stored under project/public/download/info.pdf
        $documento=Documentos::find($id);
        $file="documentos/".$documento->idcliente."/".$documento->ruta;
        return Response::download($file);
    }

}



