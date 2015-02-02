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
					Datos Cliente
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
					    <label for="field-2" class="col-sm-2 control-label">Empresa: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "empresa", null, array("class" => "form-control", "placeholder"=>"Empresa", "id"=>"field-2"))}}
                        </div>

						<label for="field-1" class="col-sm-2 control-label">Cif: </label>
						<div class="col-sm-3">
				        {{Form::input("text", "cif", null, array("class" => "form-control", "placeholder"=>"Cif", "id"=>"field-1"))}}
						</div>

				    </div>
				    <div class="form-group">
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
                         <label for="field-5" class="col-sm-2 control-label">Observaciones: </label>
                         <div class="col-sm-8">
                         <textarea name="observaciones" class="form-control autogrow" id="field-ta" placeholder="Escribe aqui las observaciones o cualquier dato de interés sobre el cliente."></textarea>
                         </div>
                      </div>
                     <div class="form-group">
                         <label for="field-5" class="col-sm-2 control-label">Pertenece a: </label>
                         <div class="col-sm-3">
                         <select id="grupo" name="grupo" class="form-control" onchange="activargruponuevo(this);">
                             <option value="" disabled selected>Seleccione un grupo</option>
                             <option value='*'>Crear nuevo grupo</option>

                              {{$registros= Grupo::distinct()->groupBy('nombre')->get()}};

                              @foreach($registros as $registro)
                              echo "<option value='{{$registro->id}}'>{{$registro->nombre}}</option>";
                              @endforeach
                         </select>
                         </div>
                         <div class="col-sm-3">
                         {{Form::input("text", "nuevogrupo", null, array("class" => "form-control","placeholder"=>"Nuevo grupo",  "id"=>"nuevogrupo", "disabled"=>true))}}
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
<script type="text/javascript">
function activargruponuevo(selec) {
    if (selec.value == '*') {
    document.getElementById('nuevogrupo').disabled = false;
    }else{
    document.getElementById('nuevogrupo').disabled = true;
    }
}
</script>
@stop


