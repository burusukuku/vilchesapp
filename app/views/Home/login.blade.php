@extends('layouts.neonlogin')

@section('head')
<title>VilchesApp - Login</title>
<meta name='title' content='Login'>
<meta name='description' content='Login'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop


@section('frase')
<p class="description">Debe usted loguearse para entrar al sistema!</p>
@stop

@section('contenido')

<div class="login-content">

            {{Session::get('message')}}
			{{Form::open(array(
                        "method" => "POST",
                        "action" => "HomeController@login",
                        "role" => "form",
                        "id" => "form",
                        ))}}

				<div class="form-group">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>

						{{Form::input("usuario", "usuario", null, array("class" => "form-control", "placeholder"=>"Usuario"))}}
					</div>

				</div>

				<div class="form-group">

					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>

						{{Form::input("password", "password", null, array("class" => "form-control", "placeholder"=>"Contraseña"))}}
					</div>

				</div>
				<div class="form-group">
				{{Form::label("Recordar sesión:")}}
                {{Form::input("checkbox", "remember", "On")}}
                </div>

				<div class="form-group">
					{{Form::input("hidden", "_token", csrf_token())}}
                    {{Form::input("submit", null, "Entrar", array("class" => "btn btn-primary btn-block btn-login"))}}
				</div>


{{Form::close()}}
<div class="login-bottom-links">

				<a href="{{URL::route('recoverpassword')}}" class="link">Olvidó su contraseña?</a>

				<br />

				<a href="#">ToS</a>  - <a href="#">Politica de privacidad</a>

			</div>
</div>
@stop




