<?php
use Carbon\Carbon;

class UsuariosController extends BaseController {


    public function index()
    {
        $paginacion = Usuarios::orderBy('id')->get();
        return View::make('usuarios.index', array('paginacion' => $paginacion));
    }

    public function crear()
    {
        return View::make('Usuarios.crear');
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

        $rules = array(
            "user" => "required|unique:usuarios,user",
            "email" => "required|email",
            "password" => "required|confirmed",
            "tipo" => "required",
        );




        $messages = array(

            "user.unique" => "El usuario ya existe en la base de datos",
            "user.required" => "El nombre del usuario es requerido",
            "email.required" => "El correo es requerido",
            "email.email" => "El correo no tiene un formato adecuado",
            "password.required" => "La contraseña es requerida",
            "password.confirmed" => "La confirmación de la contraseña no es correcta",
            "tipo.required" => "El tipo de usuario es requerido",
        );

        $confirmacion = array(
            "ok" => "El Usuario ha sido guardado con exito");

        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {


            $usuarios = Usuarios::create(array(
                'user' => Input::get('user'),
                'email' => Input::get('email'),
                'password' => Hash::make(Input::get('password')),
                'tipo' => Input::get('tipo'),
                'active' => '1',
            ));


            $usuarios=Usuarios::all();
            Event::fire('auditoria', array($usuarios->last()->id, Auth::user()->get()->user, $usuarios->last(), 'Usuarios', 'Alta'));
            return Redirect::action('UsuariosController@index')->withinput()->withErrors($confirmacion);
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
          @page { margin: 70px 32px; }

          #footer { position: fixed; left: 0px; bottom: -160px; right: 0px; height: 165px;}
          #footer .page:after { content: counter(page, decimal);}
        </style>
    <link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"  id="style-resource-1">
	<link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css"  id="style-resource-2">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"  id="style-resource-3">
	<link rel="stylesheet" href="/neon/assets/css/bootstrap.css"  id="style-resource-4">
	<link rel="stylesheet" href="/neon/assets/css/neon.core.min.css"  id="style-resource-5">
	<link rel="stylesheet" href="/neon/assets/css/neon-core.css"  id="style-resource-9">
	<link rel="stylesheet" href="/neon/assets/css/neon-theme.css"  id="style-resource-6">
	<link rel="stylesheet" href="/neon/assets/css/neon-forms.css"  id="style-resource-7">
	<link rel="stylesheet" href="/neon/assets/css/custom.css"  id="style-resource-8">
	<link rel="stylesheet" href="/neon/assets/css/cajas.css"  id="style-resource-9">
	</head><body class="page-body"><div class="page-container">';
        $html.= '<div class="imagenlogo" style="text-align: center;"><img src="./neon/assets/images/logo2.png" width="150px" height="70px" /></div>';
        $html.= '<div class="col-xs-6 col-left"><h3>Clientes:</h3></div>';
        $html.= '<div class="row">';
        $html.= '<table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" style="width: 800px;">';
        $html.= '<thead><tr>';
        $html.= '<td><strong>Id</strong></td><td><strong>Dni</strong></td><td><strong>Nombre</strong></td><td><strong>Apellidos</strong></td><td><strong>Teléfono</strong></td><td><strong>Email</strong></td>';
        $html.= '</tr></thead><tbody>';
        $cartas = Clientes::orderBy('apell1')->get();
        foreach ($cartas as $fila) {
            $html.= '<tr>';
            $html.= '<td>'. $fila['id'] .'</td>';
            $html.= '<td>'. $fila['dni'] .'</td>';
            $html.= '<td>'. $fila['nombre'] .'</td>';
            $html.= '<td>'. $fila['apell1'] .' '.$fila['apell2'] .'</td>';
            $html.= '<td>'. $fila['telefono'] .'</td>';
            $html.= '<td>'. $fila['email'] .'</td>';
            $html.= '</tr>';
        }

        $html.= '</tbody></table></div>';
        $html.= '<div id="footer"><div align="center" style="font-size:11px;">Esta información es CONFIDENCIAL y está sometida a secreto profesional o cuya divulgación está prohibida por la ley. Si ha recibido este informe por error, debe saber que su lectura, copia y uso estan prohibidos. Le rogamos que nos lo comunique inmediatamente y proceda a su destrucción.</div>
         <div align="right" class="page" style="font-size:13px;">Pag: </div></div></div></div>';
        $html.= '</body></html>';


        return PDF::load($html, 'A4', 'portrait')->show();
    }

}



