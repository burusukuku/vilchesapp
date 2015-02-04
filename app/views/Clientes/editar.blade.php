@extends('...layouts.neon')


@section('head')
<title>Editar Cliente</title>
<meta name='description' content='Editar Cliente'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')
<h1>Editar Cliente</h1>
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
                                        "action" => "ClientesController@actualizar",
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
                        <label for="field-1" class="col-sm-2 control-label">Cif: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "cif", $clientes->cif, array("class" => "form-control", "placeholder"=>"Cif", "id"=>"field-1"))}}
                        </div>
                    </div>
					<div class="form-group">
					    <label for="field-2" class="col-sm-2 control-label">Empresa: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "empresa", $clientes->empresa, array("class" => "form-control", "placeholder"=>"Empresa", "id"=>"field-2"))}}
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="field-5" class="col-sm-2 control-label">Dirección: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "direccion", $clientes->direccion, array("class" => "form-control", "placeholder"=>"Dirección", "id"=>"field-5"))}}
                        </div>
                        <label for="field-6" class="col-sm-1 control-label">Localidad: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "localidad", $clientes->localidad, array("class" => "form-control","placeholder"=>"Localidad",  "id"=>"field-6"))}}
                        </div>
                     </div>
                     <div class="form-group">
                         <label for="field-5" class="col-sm-2 control-label">Observaciones: </label>
                         <div class="col-sm-8">
                         <textarea name="observaciones" class="form-control autogrow" id="field-ta" placeholder="Escribe aqui las observaciones o cualquier dato de interés sobre el cliente.">{{$clientes->observaciones}}</textarea>
                         </div>
                      </div>
                     <div class="form-group">
                         <label for="field-5" class="col-sm-2 control-label">Pertenece a: </label>
                         <div class="col-sm-3">
                         <select id="grupo" name="grupo" class="form-control" onchange="activargruponuevo(this);">
                               <?$grupos= Grupo::select('id','nombre')->get();?>
                                @foreach($grupos as $mostrar)
                                   <? if($clientes->grupo == $mostrar->id){?>
                                   echo "<option value='{{$mostrar->nombre}}' disabled selected>{{$mostrar->nombre}}</option>";
                                   <?}?>
                                @endforeach
                             <option value='*'>Crear nuevo grupo ----></option>

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
						    {{Form::input("hidden", "id", $clientes->id)}}
                            {{Form::input("submit", null, "Guardar cambios", array("class" => "btn btn-default"))}}
                         </div>
					{{Form::close()}}
				</form>

			</div>

		</div>

	</div>
</div>
</div>




<script type="text/javascript">
function activargruponuevo(selec) {
    if (selec.value == '*') {
    document.getElementById('nuevogrupo').style.display = 'block';
    document.getElementById('nuevogrupo').disabled = false;
    }else{
    document.getElementById('nuevogrupo').disabled = true;
    document.getElementById('nuevogrupo').style.display = 'none';
    }
}

window.onload = function(){
   document.getElementById('nuevogrupo').style.display = 'none';
   }
</script>
@stop


