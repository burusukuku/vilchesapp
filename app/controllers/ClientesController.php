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
        return View::make('clientes.crear');
    }

    public function mostrar($id)
    {

        $clientes =  Clientes::find($id);
        return View::make('clientes.mostrar', array('clientes' => $clientes));
    }

    public function vercontactos($id)
    {

        $clientes =  Clientes::find($id);
        return View::make('clientes.vercontactos', array('clientes' => $clientes));
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


            if($grupo=='*'){
                Grupo::create(array('nombre'=>Input::get('nuevogrupo')));
                $grupo=Grupo::all()->last()->id;
            }

            $clientes = Clientes::create(array(
                'cif' => Input::get('cif'),
                'empresa' => Input::get('empresa'),
                'telefono' => Input::get('telefono'),
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
        $clientes->telefono = Input::get('telefono');
        $clientes->direccion = Input::get('direccion');
        $clientes->localidad = Input::get('localidad');
        $clientes->observaciones = Input::get('observaciones');

        $grupo=Input::get('grupo');
        if($grupo!='') //Si se ha cambiado grupo
        {
        $clientes->grupo = $grupo;
        }

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
            $ruta = Funciones::sanear_string(Input::file("documento")->getClientOriginalName());
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

            $file->move("documentos/" . $id, Funciones::sanear_string($file->getClientOriginalName()));
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

        $contactos=Contactos::where('id_cli','=',$id)->get();
        foreach($contactos as $contacto)
        {
                Event::fire('auditoria', array(($contacto->id), Auth::user()->get()->user, Contactos::find($contacto->id), 'Contactos', 'Baja'));
                Contactos::find($contacto->id)->delete();
        }
        Clientes::find($id)->delete();

        return Redirect::action('ClientesController@index');
    }

    public function aniadircontacto()
    {
        $rules = array(
            'nombre' => 'required|unique_with:contactos_cli,apell1,apell2,telefono',
        );

        $messages = array(
            "nombre.required" => "El campo nombre de la persona es requerido",
            "nombre.uniqued" => "La persona ya existe en la base de datos",
        );



        $validator = Validator::make(Input::All(), $rules, $messages);
        $id_cli = Input::get('id_cli');
        if ($validator->passes()) {

            $contactos = Contactos::create(array(
                'id_cli' => $id_cli,
                'nombre' => Input::get('nombre'),
                'apell1' => Input::get('apell1'),
                'apell2' => Input::get('apell2'),
                'telefono' => Input::get('telefono'),
                'email' => Input::get('email'),
                'direccion' => Input::get('direccion'),
                'localidad' => Input::get('localidad'),
            ));


            $contactos = Contactos::all();
            Event::fire('auditoria', array($contactos->last()->id, Auth::user()->get()->user, $contactos->last(), 'Contactos', 'Alta'));
            return Redirect::action('ClientesController@mostrar', array('id' => $id_cli))->with('exito','La persona de contacto ha sido guardada correctamente' );
        } else {
            return Redirect::action('ClientesController@mostrar', array('id' => $id_cli))->withErrors($validator);
        }
    }

     public function eliminarcontacto($id)
    {
        $id_cli=Contactos::find($id)->id_cli;
        
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Contactos::find($id), 'Contactos', 'Baja'));
        Contactos::find($id)->delete();

        return Redirect::action('ClientesController@mostrar', array('id' => $id_cli))->with('exito','La persona de contacto ha sido eliminada correctamente' );

    }

    public function descargar($id)
    {
        //PDF file is stored under project/public/download/info.pdf
        $documento=Documentos::find($id);
        $file="documentos/".$documento->idcliente."/".$documento->ruta;
        return Response::download($file);
    }

    public function clientespdf()
    {
        $html = '<html><head><meta charset="utf-8"><link rel="stylesheet" href="/neon/assets/css/bootstrap.css"  id="style-resource-4">';
        $html.= '<style type="text/css">
          @page { margin: 70px 60px }

          #footer { position: fixed; left: 0px; bottom: -160px; right: 0px; height: 165px;}
          #footer .page:after { content: counter(page, decimal);}
          .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
            background-color: #f5f5f6;
            border-bottom-width: 1px;
            color: black;
        }
        </style>
    <link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"  id="style-resource-1">
	<link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css"  id="style-resource-2">
	<link rel="stylesheet" href="/neon/assets/css/fonts/googlefont.css"  id="style-resource-3">
	<link rel="stylesheet" href="/neon/assets/css/bootstrap.css"  id="style-resource-4">
	<link rel="stylesheet" href="/neon/assets/css/neon.core.min.css"  id="style-resource-5">
	<link rel="stylesheet" href="/neon/assets/css/neon-core.css"  id="style-resource-9">
	<link rel="stylesheet" href="/neon/assets/css/neon-theme.css"  id="style-resource-6">
	<link rel="stylesheet" href="/neon/assets/css/neon-forms.css"  id="style-resource-7">
	<link rel="stylesheet" href="/neon/assets/css/custom.css"  id="style-resource-8">
	<link rel="stylesheet" href="/neon/assets/css/cajas.css"  id="style-resource-9">
	</head><body class="page-body"><div class="page-container">';
        $html.= '<div class="imagenlogo" style="text-align: center;"><img src="./neon/assets/images/logo2.png" width="150px" height="70px" /></div>';
        $html.= '<div class="col-xs-6 col-left"><h3>Listado de Clientes:</h3></div>';
        $html.= '<div class="row">';
        $html.= '<table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" style="width: 650px;">';
        $html.= '<thead><tr>';
        $html.= '<td><strong>Id</strong></td><td><strong>Cif</strong></td><td><strong>Empresa</strong></td><td><strong>Localidad</strong></td><td><strong>Grupo</strong></td>';
        $html.= '</tr></thead><tbody>';
        $cartas = Clientes::orderBy('empresa')->get();
        foreach ($cartas as $fila) {
            $html.= '<tr>';
            $html.= '<td>'. $fila['id'] .'</td>';
            $html.= '<td>'. $fila['cif'] .'</td>';
            $html.= '<td>'. $fila['empresa'] .'</td>';
            $html.= '<td>'. $fila['localidad'] .'</td>';
            $grupo=$fila['grupo'];
            if($grupo == '0' || $grupo ==NULL){
                 $html.= '<td>Sin Grupo</td>';
            }else{
                $html.= '<td>'. Grupo::find($fila['grupo'])->nombre .'</td>';
            }
            $html.= '</tr>';
        }

        $html.= '</tbody></table></div>';
        $html.= '<div id="footer"><div align="center" style="font-size:11px;">Esta información es CONFIDENCIAL y está sometida a secreto profesional o cuya divulgación está prohibida por la ley. Si ha recibido este informe por error, debe saber que su lectura, copia y uso estan prohibidos. Le rogamos que nos lo comunique inmediatamente y proceda a su destrucción.</div>
         <div align="right" class="page" style="font-size:13px;">Pag: </div></div></div></div>';
        $html.= '</body></html>';


        return PDF::load($html, 'A4', 'portrait')->show();
    }

}



