@extends('...layouts.neon')


@section('head')
<title>Crear Cliente</title>
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
<h1>Añadir Cliente</h1>
<div class="row">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Datos Personales
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "ClientesController@guardar",
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

						<label for="field-1" class="col-sm-2 control-label">Dni: </label>

						<div class="col-sm-3">
				        {{Form::input("text", "dni", null, array("class" => "form-control", "placeholder"=>"Dni", "id"=>"field-1"))}}
						</div>
				        <label for="field-2" class="col-sm-2 control-label">Nombre: </label>
						<div class="col-sm-3">
						{{Form::input("text", "nombre", null, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-2"))}}
				        </div>
				    </div>
				    <div class="form-group">
				        <label for="field-3" class="col-sm-2 control-label">1º Apellido: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "apell1", null, array("class" => "form-control", "placeholder"=>"1º Apellido", "id"=>"field-3"))}}
                        </div>
						<label for="field-4" class="col-sm-2 control-label">2º Apellido: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "apell2", null, array("class" => "form-control", "placeholder"=>"2º Apellido", "id"=>"field-4"))}}
                        </div>
					</div>
				    <div class="form-group">
                        <label for="field-5" class="col-sm-2 control-label">Teléfono: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "telefono", null, array("class" => "form-control", "placeholder"=>"Teléfono", "id"=>"field-5"))}}
                        </div>
                        <label for="field-6" class="col-sm-2 control-label">Fecha_nac: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "fecha_nac", null, array("class" => "form-control","placeholder"=>"Fecha de nacimiento",  "id"=>"field-6", "data-mask"=>"date"))}}
                        </div>
                    </div>
                     <div class="form-group">
                         <label for="field-5" class="col-sm-2 control-label">Correo: </label>
                         <div class="col-sm-3">
                         {{Form::input("text", "email", null, array("class" => "form-control", "placeholder"=>"Correo", "id"=>"field-5"))}}
                         </div>
                     </div>
                     <div class="form-group">
                        <label for="field-5" class="col-sm-2 control-label">Dirección: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "direccion", null, array("class" => "form-control", "placeholder"=>"Dirección", "id"=>"field-5"))}}
                        </div>
                        <label for="field-6" class="col-sm-2 control-label">Localidad: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "localidad", null, array("class" => "form-control","placeholder"=>"Localidad",  "id"=>"field-6"))}}
                        </div>
                     </div>

					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-5">
						    {{Form::input("hidden", "_token", csrf_token())}}
                            {{Form::input("submit", null, "Añadir nuevo cliente", array("class" => "btn btn-default"))}}
                        </div>
					{{Form::close()}}
				</form>

			</div>

		</div>

	</div>
</div>

@stop


