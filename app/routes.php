<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::when('*','csrf', ['post']);

//RUTAS PARA INVITADOS
Route::group(array('before' => 'guest_user'), function() {
    Route::get('/recoverpassword', array('as' => 'recoverpassword', 'uses' => 'HomeController@recoverpassword'));
    Route::any('/password/reset/{token}', array('as' => 'resetpassword', 'uses' => 'HomeController@resetpassword'));
    Route::get('/updatepassword', array('as' => 'updatepassword', 'uses' => 'HomeController@updatepassword'));
    Route::get('/login', array('as' => 'login', 'uses' => 'HomeController@login'));
});

// RUTAS PARA LOGUEADOS
Route::group(array('before' => 'auth_user'), function() {

    //Clientes
    Route::group(array('prefix' => 'clientes'), function() {
        Route::get('/',array('as' => 'clientes.index', 'uses' => 'ClientesController@index'));
        Route::get('/crear',array('as' => 'clientes.crear', 'uses' => 'ClientesController@crear'));
        Route::post('/',array('as' => 'clientes.guardar', 'uses' => 'ClientesController@guardar'));
        Route::post('/documento', array('as' => 'clientes.subirdocumento', 'uses' => 'ClientesController@subirdocumento'));
        Route::get('/editar/{id}', array('as' => 'clientes.editar', 'uses' => 'ClientesController@editar'));
        Route::post('/editar/{id}', array('as' => 'clientes.aniadircontacto', 'uses' => 'ClientesController@aniadircontacto'));
        Route::get('/mostrar/{id}', array('as' => 'clientes.mostrar', 'uses' => 'ClientesController@mostrar'));
        Route::post('/actualizar', array('as' => 'clientes.actualizar', 'uses' => 'ClientesController@actualizar'));
        Route::get('/eliminar/{id}', array('as' => 'clientes.eliminar', 'uses' => 'ClientesController@eliminar'));
        Route::get('/documento/eliminar/{id}', array('as' => 'clientes.eliminardocumento', 'uses' => 'ClientesController@eliminardocumento'));
        Route::get('/vercontactos/{id}',array('as' => 'clientes.vercontactos', 'uses' => 'ClientesController@vercontactos'));
        Route::get('/eliminarcontacto/{id}',array('as' => 'clientes.eliminarcontacto', 'uses' => 'ClientesController@eliminarcontacto'));
        Route::get('/clientespdf', array('as' => 'clientespdf', 'uses' => 'ClientesController@clientespdf'));
        Route::get('/descargar/{id}', array('as' => 'clientes.descargar', 'uses' => 'ClientesController@descargar'));
    });
    
    //Rutas para Boletines
    Route::group(array('prefix' => 'boletin'), function() {
        Route::get('/',array('as' => 'boletin.index', 'uses' => 'BoletinesController@index'));
        Route::get('/crear', array('as' => 'boletin.crear', 'uses' => 'BoletinesController@crear'));
        Route::post('/', array('as' => 'boletin.enviar', 'uses' => 'BoletinesController@enviar'));
        Route::get('/mostrar/{id}', array('as' => 'boletin.mostrar', 'uses' => 'BoletinesController@mostrar'));
        Route::get('/eliminarclienteani/{id}', array('as' => 'boletin.eliminarclienteani', 'uses' => 'BoletinesController@eliminarclienteani'));
        Route::post('/aniadircliente', array('as' => 'boletin.aniadircliente', 'uses' => 'BoletinesController@aniadircliente'));
        Route::post('/aniadirclienteexc', array('as' => 'boletin.aniadirclienteexc', 'uses' => 'BoletinesController@aniadirclienteexc'));
        Route::get('/eliminarclienteexc/{id}', array('as' => 'boletin.eliminarclienteexc', 'uses' => 'BoletinesController@eliminarclienteexc'));
    });

    //Rutas para Configuracion
    Route::group(array('prefix' => 'configuracion'), function() {
        Route::get('/', array('as' => 'configuracion.index', 'uses' => 'ConfiguracionController@index'));
        Route::get('/editarcorreo', array('as' => 'configuracion.editarcorreo', 'uses' => 'ConfiguracionController@editarcorreo'));
        Route::post('/actualizarcorreo', array('as' => 'configuracion.actualizarcorreo', 'uses' => 'ConfiguracionController@actualizarcorreo'));
        Route::post('/envioprueba', array('as' => 'configuracion.envioprueba', 'uses' => 'ConfiguracionController@envioprueba'));
    });

    Route::get('/grupoexcluidos', function(){
        $grupo = Input::get('option');
        if($grupo== '*'){ // si son todos, puede excluir a cualquier persona
            $clientes=Clientes::all();
        }else{ // Si elige un grupo, podrá excluir a gente de ese grupo
        $clientes = Clientes::where('grupo', '=', $grupo)->get();
        }
        $opciones = array();

        foreach ($clientes as $cliente) {
            $opciones += array($cliente->id => $cliente->empresa);
        }

        return Response::json($opciones);

    });

    Route::get('/grupoaniadidos', function(){
        $grupo = Input::get('option');
        if($grupo=='*'){ //si son todos, no debe añadir ninguno adicional
            $clientes=array();
        }else{ // Si elige un grupo, solo añadirá gente que no esté en ese grupo
             $clientes = Clientes::where('grupo', '!=', $grupo)->get();
        }
        $opciones = array();

        foreach ($clientes as $cliente) {
            $opciones += array($cliente->id => $cliente->empresa);
        }

        return Response::json($opciones);

    });
    Route::get('/aniadir', function(){
       
        $cliente = Input::get('cliente');
        
        //Insertamos el cliente en el boletin
        $boletin = Boletines::create(array(
                'id_cli_ani' => $cliente,
            ));
        //Sacamos todos los clientes añadidos hasta el momento
        $registros= Boletines::where('num_boletin','=','0')->where('id_cli_ani','!=','0')->get();
        //Consultamos la información de cada cliente
        foreach($registros as $fila){
        $clientes= Clientes::find($fila->id_cli_ani);
        }

        $opciones = array();
        //insertamos la información en el array
        foreach ($clientes as $cliente) {
            $opciones += array($cliente->id => $cliente->empresa);
        }
        //devolvemos el array
        return Response::json($opciones);

    });

     

    //Rutas para Empresa
    Route::group(array('prefix' => 'empresa'), function() {
        Route::get('/', array('as' => 'empresa.index', 'uses' => 'EmpresaController@index'));
        Route::get('/editar', array('as' => 'empresa.editar', 'uses' => 'EmpresaController@editar'));
        Route::post('/actualizar', array('as' => 'empresa.actualizar', 'uses' => 'EmpresaController@actualizar'));
    });


    //Otros
    Route::get('/',array('as' => 'index', 'uses' => 'HomeController@index'));
    Route::get('/salir', array('as' => 'salir', 'uses' => 'HomeController@salir'));

});
// RUTAS PARA ADMINS
Route::group(array('before' => 'admin'), function()
{
    Route::get('/usuarios',array('as' => 'usuarios.index', 'uses' => 'UsuariosController@index'));
    Route::get('/usuarios/crear',array('as' => 'usuarios.crear', 'uses' => 'UsuariosController@crear'));
    Route::post('/usuarios',array('as' => 'usuarios.guardar', 'uses' => 'UsuariosController@guardar'));
    Route::get('/usuarios/eliminar/{id}',array('as' => 'usuarios.eliminar', 'uses' => 'UsuariosController@eliminar'));
    Route::get('/usuarios/editar/{id}',array('as' => 'usuarios.editar', 'uses' => 'UsuariosController@editar'));
    Route::post('/usuarios/actualizar',array('as' => 'usuarios.actualizar', 'uses' => 'UsuariosController@actualizar'));
    Route::get('/usuarios/mostrar/{id}',array('as' => 'usuarios.mostrar', 'uses' => 'UsuariosController@mostrar'));
});


//Recogida de datos con Post para el login
Route::post('/login', array('before' => 'csrf', function(){
    $user = array(
        'user' => Input::get('usuario'),
        'password' => Input::get('password'),
        'activo' => 1,
    );

    $remember = Input::get("remember");
    $remember == 'On' ? $remember = true : $remember = false;


    if (Auth::user()->attempt($user, $remember)){

        return Redirect::route("index");
    } else{
        $message = "<div class='errorHandler alert alert-danger'><i class='icon-remove-sign'></i> El usuario o la contraseña no son válidos.
					</div>";
        return Redirect::route("login")->with("message", $message);
    }
}));



//recogida de datos para el recovery
Route::post('/recoverpassword', array('before' => 'csrf', function(){


    $rules = array(
        "email" => "required|email|exists:usuarios",
    );

    $messages = array(
        "email.required" => "El campo email es requerido",
        "email.email" => "El formato de email es incorrecto",
        "email.exists" => "El email seleccionado no se encuentra registrado",
    );

    $validator = Validator::make(Input::All(), $rules, $messages);

    if($validator->passes()){
        Password::user()->remind(Input::only("email"), function($message) {
            $message->subject('Recuperar contraseña de VilchesApp');
        });
        $message = '<hr><label class="label label-info">Le hemos enviado un email a su cuenta de correo</label><hr>';
        return Redirect::route('recoverpassword')->with("message", $message);
    }else{
        return Redirect::back()->withinput()->withErrors($validator);
    }
}));

//Recogida de datos para el update
Route::post('/updatepassword', array('before' => 'csrf', function(){

    $credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password'),
        'password_confirmation' => Input::get('password_confirmation'),
        'token' => Input::get('token'),
    );
    if (Auth::user()->attempt(array('email' => Input::get('email')))) {
        Password::user()->reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
    }else{
        $message = '<hr><label class="label label-info">El Email no existe.</label><hr>';
        return Redirect::to("resetpassword/user/".Input::get('token'))->with("message", $message);
    };

    $message = '<hr><label class="label label-info">Password cambiado con éxito, ya puedes iniciar sesión</label><hr>';
    return Redirect::to('login')->with('message', $message);

}));



// Redireccion a la página de error 404

App::missing(function($exception){
    return Response::view('error.error404', array(), 404);
});
