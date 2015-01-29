@extends('...layouts.neon')


@section('head')
<title>Añadir usuario</title>
<meta name='description' content='Crear Cliente'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')
<h1>Añadir Usuario</h1>
<div class="row">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Datos Usuario
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "UsuariosController@guardar",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        ))}}
                        @if ($errors->any())
                            <div class="error mensajes">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <strong>Por favor corrige los siguentes errores:</strong>
                              <ul>
                              @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                              @endforeach
                              </ul>
                            </div>
                         @endif


				    <div class="form-group">
				    <label for="field-2" class="col-md-4 control-label">Nombre: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "user", null, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-2"))}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-5" class="col-md-4 control-label">Correo: </label>
                         <div class="col-md-4">
                         {{Form::input("text", "email", null, array("class" => "form-control", "placeholder"=>"Correo", "id"=>"field-5"))}}
                         </div>
                     </div>

				    <div class="form-group">
                        <label for="field-5" class="col-md-3 control-label">Contraseña: </label>
                        <div class="col-md-3">
                        {{Form::input("password", "password", null, array("class" => "form-control", "placeholder"=>"Contraseña", "id"=>"field-5"))}}
                        </div>
                         <div class="col-md-3">
                         {{Form::input("password", "password_confirmation", null, array("class" => "form-control", "placeholder"=>"Repetir contraseña", "id"=>"field-5"))}}
                         </div>
                    </div>
                     <div class="form-group">
                         <label for="field-5" class="col-md-4 control-label">Tipo de usuarios: </label>
                         <div class="col-md-4">
                         <select id="tipo" name="tipo" class="form-control">
                             <option value="" disabled selected>Seleccione un tipo de usuario</option>
                             <option value='user'>Usuario</option>
                             <option value='admin'>Administrador</option>
                         </select>
                         </div>
                      </div>

					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-5">
						    {{Form::input("hidden", "_token", csrf_token())}}
						    <button type="submit" class="btn btn-default btn-icon icon-left">
                            Añadir nuevo usuario
                            <i class="entypo-user-add"></i> </button>
                        </div>
					{{Form::close()}}
				</form>

			</div>

		</div>

	</div>
</div>
@stop


