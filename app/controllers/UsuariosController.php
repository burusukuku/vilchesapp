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
        return View::make('usuarios.crear');
    }

    public function mostrar($id)
    {

        $usuarios =  Usuarios::find($id);
        return View::make('usuarios.mostrar', array('usuarios' => $usuarios));
    }

    public function editar($id)
    {

        $usuarios =  Usuarios::find($id);
        return View::make('usuarios.editar', array('usuarios' => $usuarios));
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



        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {


            $usuarios = Usuarios::create(array(
                'user' => Input::get('user'),
                'email' => Input::get('email'),
                'password' => Hash::make(Input::get('password')),
                'tipo' => Input::get('tipo'),
                'activo' => '1',
            ));


            $usuarios=Usuarios::all();
            Event::fire('auditoria', array($usuarios->last()->id, Auth::user()->get()->user, $usuarios->last(), 'Usuarios', 'Alta'));
            return Redirect::action('UsuariosController@index')->with('exito','El usuario ha sido registrado' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }

    public function actualizar()
    {
        $id = Input::get('id');
        $rules = array(
            "user" => "required|unique:usuarios,user,$id",
            "email" => "required|email",
        );




        $messages = array(

            "user.unique" => "El usuario ya existe en la base de datos",
            "user.required" => "El nombre del usuario es requerido",
            "email.required" => "El correo es requerido",
            "email.email" => "El correo no tiene un formato adecuado",
        );



        $validator = Validator::make(Input::All(), $rules, $messages);
        if ($validator->passes()) {

            $usuarios =  Usuarios::find($id);
            $usuarios->user = Input::get('user');
            $usuarios->email = Input::get('email');
            if($usuarios->tipo!='Administrador'){
            $usuarios->tipo = Input::get('tipo');
            $usuarios->activo = Input::get('activo');
            }


            $usuarios->save();

            Event::fire('auditoria', array($id, Auth::user()->get()->user, Usuarios::find($id), 'Usuarios', 'Modificacion'));

            $usuarios =  Usuarios::find($id);

            return Redirect::action('usuarios.mostrar', array('id' => $usuarios->id))->withinput()->with('exito','El usuario se ha modificado correctamente' );
        } else {
            return Redirect::back()->withinput()->withErrors($validator);
        }
    }


    public function eliminar($id)
    {
        Event::fire('auditoria', array($id, Auth::user()->get()->user, Usuarios::find($id), 'Usuarios', 'Baja'));
        Usuarios::find($id)->delete();

        return Redirect::action('UsuariosController@index')->with('exito','El usuario ha sido eliminado' );
    }





}



