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
    Route::any('/resetpassword/{type}/{token}', array('as' => 'resetpassword', 'uses' => 'HomeController@resetpassword'));
    Route::get('/updatepassword', array('as' => 'updatepassword', 'uses' => 'HomeController@updatepassword'));
    Route::get('/login', array('as' => 'login', 'uses' => 'HomeController@login'));
});

// RUTAS PARA LOGUEADOS
Route::group(array('before' => 'auth_user'), function() {

    //Clientes
    Route::get('/clientes',array('as' => 'clientes.index', 'uses' => 'ClientesController@index'));
    Route::get('/clientes/crear',array('as' => 'clientes.crear', 'uses' => 'ClientesController@crear'));
    Route::post('/clientes',array('as' => 'clientes.guardar', 'uses' => 'ClientesController@guardar'));
    Route::post('/clientes', array('as' => 'clientes.subirdocumento', 'uses' => 'ClientesController@subirdocumento'));
    Route::get('/clientes/editar/{id}', array('as' => 'clientes.editar', 'uses' => 'ClientesController@editar'));
    Route::get('/clientes/mostrar/{id}', array('as' => 'clientes.mostrar', 'uses' => 'ClientesController@mostrar'));
    Route::post('/clientes/actualizar', array('as' => 'clientes.actualizar', 'uses' => 'ClientesController@actualizar'));
    Route::get('/clientes/eliminar/{id}', array('as' => 'clientes.eliminar', 'uses' => 'ClientesController@eliminar'));
    Route::get('/clientespdf', array('as' => 'clientespdf', 'uses' => 'ClientesController@clientespdf'));

    Route::get('/',array('as' => 'index', 'uses' => 'HomeController@index'));
    Route::get('/salir', array('as' => 'salir', 'uses' => 'HomeController@salir'));

});

//Recogida de datos con Post para el login
Route::post('/login', array('before' => 'csrf', function(){
    $user = array(
        'user' => Input::get('usuario'),
        'password' => Input::get('password'),
        'active' => 1,
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
            $message->subject('Recuperar contraseña de SiGeCat');
        });
        $message = '<hr><label class="label label-info">Le hemos enviado un email a su cuenta de correo electronico para que pueda recuperar su password</label><hr>';
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
        'password_confirmation' => Input::get('repetir_password'),
        'token' => Input::get('token'),
    );
    if (Auth::attempt(array('email' => Input::get('email')))) {
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
