@extends('layouts.neon')


@section('head')
<title>Contactos</title>
<meta name='description' content='Ficha Cliente'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')

<div class="row" id="contactos">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Contactos del cliente <a href="{{URL::route('clientes.mostrar', array('id' => $clientes->id ))}}">
                        <strong>{{$clientes->empresa}}</strong>
                    </a>
				</div>
                        <div class="panel-options">

                       <a class="btn btn-default btn-sm btn-icon icon-left" onclick="nuevocontacto();">
                        <i class="entypo-user-add"></i>Añadir contacto</a>

                        </div>

			</div>

			<div class="panel-body">
      @if(Contactos::where('id_cli','=',$clientes->id)->count()!='0')
			<table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info"">
                         	<thead>
                         		<tr>
                         			<th>Id</th>
                         			<th>Nombre</th>
                         			<th>Apellidos</th>
                         			<th>Teléfono</th>
                         			<th>Email</th>
                         			<th>Acciones</th>
                         		</tr>
                         	</thead>

                         	<tbody>
                         	<?php $contactos=Contactos::where('id_cli','=',$clientes->id)->get();?>
            <?php foreach($contactos as $fila): ?>
            		<tr>
            			<td>{{$fila->id}}</td>
            			<td>{{$fila->nombre}}</td>
            			<td>{{$fila->apell1 . " " . $fila->apell2}} </td>
            			<td>{{$fila->telefono}}</td>
            			<td>{{HTML::mailto($fila->email)}}</td>
            			<td>
            				<a href="{{URL::route('clientes.eliminarcontacto', array('id' => $fila['id'] ))}}" class="btn btn-danger btn-sm btn-icon icon-left">
            				    <i class="entypo-cancel"></i>
            				    Eliminar
            				</a>
            			</td>
            		</tr>
            <?php endforeach; ?>
            	</tbody>
            </table>
            @else
            {{'No existen contactos para este cliente'}}
            @endif

		</div>

	</div>
</div>
</div>
<div class="row" id="aniadircontacto">
      <div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

                  <div class="panel-heading">
                        <div class="panel-title">
                              Añadir persona de contacto
                        </div>
                  </div>

                  <div class="panel-body">
                {{ Form::open(array(
                                  "method" => "POST",
                                  "action" => "ClientesController@aniadircontacto",
                                  "role" => "form",
                                  "class" => "form-horizontal",
                                  )) }}

                    <div class="form-group">
                        <label for="field-2" class="col-sm-2 control-label">Nombre: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "nombre", null, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-2"))}}
                        </div>
                     </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-2 control-label">1º Apellido: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "apell1", null, array("class" => "form-control", "placeholder"=>"Primer Apellido", "id"=>"field-2"))}}
                        </div>

                        <label for="field-2" class="col-sm-2 control-label">2º Apellido: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "apell2", null, array("class" => "form-control", "placeholder"=>"Segundo Apellido", "id"=>"field-2"))}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-2 control-label">Teléfono: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "telefono", null, array("class" => "form-control", "placeholder"=>"Teléfono", "id"=>"field-2"))}}
                        </div>

                        <label for="field-2" class="col-sm-2 control-label">Email: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "email", null, array("class" => "form-control", "placeholder"=>"Email", "id"=>"field-2"))}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-2" class="col-sm-2 control-label">Dirección: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "direccion", null, array("class" => "form-control", "placeholder"=>"Dirección", "id"=>"field-2"))}}
                        </div>

                        <label for="field-2" class="col-sm-2 control-label">Localidad: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "localidad", null, array("class" => "form-control", "placeholder"=>"Localidad", "id"=>"field-2"))}}
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-offset-5 col-sm-5">
                    {{Form::input("hidden", "_token", csrf_token())}}
                    {{Form::input("hidden", "id_cli", $clientes->id)}}
                    {{Form::input("submit", null, "Añadir contacto", array("class" => "btn btn-default"))}}
                    {{Form::input("button", null, "Cancelar", array("class" => "btn btn-default", "align"=>"center", "onclick"=>"cancelar();"))}}

                    </div>
                    </div>
                {{ Form::close();}}

                  </div>

            </div>

      </div>
</div>
<script type="text/javascript">

function nuevocontacto() {
    document.getElementById('contactos').style.display = 'none';
    document.getElementById('aniadircontacto').style.display  = 'block';
}
function cancelar() {
    document.getElementById('contactos').style.display = 'block';
    document.getElementById('aniadircontacto').style.display  = 'none';
}
window.onload = function(){
   document.getElementById('aniadircontacto').style.display = 'none';
   }
</script>
@stop


