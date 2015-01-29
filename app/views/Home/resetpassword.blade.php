@extends('layouts.neonlogin')

@section('head')
<title>Nueva Contraseña</title>
<meta name='description' content='Nueva Contraseña'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop
@section('frase')
			<p class="description">Introduzca todos los campos y cambiará su contraseña.</p>
@stop
@section('contenido')

<div class="login-content">

{{Form::open(array(
            "method" => "POST",
            "action" => "HomeController@updatepassword",
            "role" => "form",
            ))}}

            <div class="form-group">



            					<div class="input-group">
            						<div class="input-group-addon">
            							<i class="entypo-user"></i>
            						</div>

            						{{Form::input("text", "email", null, array("class" => "form-control", "placeholder"=>"Email"))}}
            						<div class="bg-danger">{{$errors->first('email')}}</div>
            					</div>

            				</div>
            <div class="form-group">

            					<div class="input-group">
            						<div class="input-group-addon">
            							<i class="entypo-key"></i>
            						</div>

            						{{Form::input("password", "password", null, array("class" => "form-control", "placeholder"=>"Contraseña"))}}
            					    <div class="bg-danger">{{$errors->first('password')}}</div>
            					</div>

            				</div>

            <div class="form-group">

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="entypo-key"></i>
                                    </div>

                                    {{Form::input("password", "password_confirmation", null, array("class" => "form-control", "placeholder"=>"Repetir Contraseña"))}}
                                    <div class="bg-danger">{{$errors->first('password')}}</div>
                                    <div class="bg-danger">{{$errors->first('repetir_password')}}</div>
                                </div>

                            </div>

           <div class="form-group">
           					{{Form::input("hidden", "_token", csrf_token())}}
           					{{Form::input("hidden", "token", $token)}}
                            {{Form::input("submit", null, "Recuperar Contraseña", array("class" => "btn btn-primary btn-block btn-login"))}}
           				</div>


</div>
{{Form::close()}}

@stop






