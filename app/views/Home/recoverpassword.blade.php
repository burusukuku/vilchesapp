@extends('layouts.neonlogin')
@section('head')
<title>Recovery</title>
<meta name='title' content='Recuperar Contraseña'>
<meta name='description' content='Recuperar Contraseña'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='noindex,nofollow'>
@stop
@section('frase')
			<p class="description">Introduzca su Email y se le mandará un email para recuperar su contraseña.</p>
@stop

@section('contenido')

		<div class="login-content">

			{{Session::get('message')}}
            			{{Form::open(array(
                                    "method" => "POST",
                                    "action" => "HomeController@recoverpassword",
                                    "role" => "form",
                                    ))}}

            				<div class="form-group">



            					<div class="input-group">
            						<div class="input-group-addon">
            							<i class="entypo-user"></i>
            						</div>

            						{{Form::input("text", "email", null, array("class" => "form-control", "placeholder"=>"Email"))}}
            					</div>

            				</div>

						<div class="form-group">
                        					{{Form::input("hidden", "_token", csrf_token())}}
                                            {{Form::input("submit", null, "Recuperar Contraseña", array("class" => "btn btn-info btn-block btn-login"))}}
                        				</div>


            {{Form::close()}}


			<div class="login-bottom-links">

				<a href="{{URL::route('login')}}" class="link">
					<i class="entypo-lock"></i>
					Volver a la página de Login
				</a>

				<br />

				<a href="#">ToS</a>  - <a href="#">Privacy Policy</a>

			</div>

		</div>
@stop