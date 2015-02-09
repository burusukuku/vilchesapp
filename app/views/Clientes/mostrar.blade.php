@extends('...layouts.neon')


@section('head')
<title>Ficha Cliente</title>
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

<h1>Ficha Cliente</h1>
<div class="row" id="clientes">
	<div class="col-md-12">

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
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Datos Cliente
				</div>
				<div class="panel-options">

				    <a class="btn btn-green btn-sm btn-icon icon-left" onclick="nuevodocumento();">
                          <i class="entypo-up"></i>Subir documento</a>


                       <a class="btn btn-default btn-sm btn-icon icon-left" onclick="nuevocontacto();">
                        <i class="entypo-user-add"></i>Añadir contacto</a>

				     <a href="{{URL::route('clientes.editar', array('id' => $clientes->id))}}" class="btn btn-default btn-sm btn-icon icon-left">
                          <i class="entypo-pencil"></i>Editar
                    </a>
                    <a href="{{URL::route('clientes.eliminar', array('id' => $clientes->id))}}" class="btn btn-danger btn-sm btn-icon icon-left delete-event" data-title="¿Me lo puedes confirmar?", data-content="¿Estás seguro de querer eliminar los datos?" onClick="return false;">
                      <i class="entypo-cancel"></i>
                      Eliminar
                    </a>
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                     "role" => "form",
                     "class" => "form-horizontal",
                    ))}}

                <? $id_cli=$clientes->id;?>
					<div class="form-group">

					    <label for="field-2" class="col-sm-2 control-label">Cif: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "dni", $clientes->cif, array("class" => "form-control", "placeholder"=>"Cif", "id"=>"field-2",'disabled'))}}
                        </div>
                    </div>
                    <div class="form-group">
						<label for="field-1" class="col-sm-2 control-label">Empresa: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "nombre", $clientes->empresa, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-1", 'disabled'))}}
                        </div>

				    </div>


                     <div class="form-group">
                        <label for="field-6" class="col-sm-2 control-label">Dirección: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "direccion", $clientes->direccion, array("class" => "form-control", "placeholder"=>"Dirección", "id"=>"field-6",'disabled'))}}
                        </div>
                        <label for="field-7" class="col-sm-2 control-label">Localidad: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "localidad", $clientes->localidad, array("class" => "form-control","placeholder"=>"Localidad",  "id"=>"field-7",'disabled'))}}
                        </div>
                     </div>
                     <div class="form-group">
                          <label for="field-5" class="col-sm-2 control-label">Observaciones: </label>
                          <div class="col-sm-8">
                          <textarea name="observaciones" class="form-control autogrow" id="field-ta" placeholder="Escribe aqui las observaciones o cualquier dato de interés sobre el cliente." disabled>{{$clientes->observaciones}}</textarea>
                          </div>
                       </div>
                     <div class="form-group">
                          <label for="field-5" class="col-sm-2 control-label">Pertenece a: </label>
                          <div class="col-sm-3">
                          <?
                            if($clientes->grupo == NULL){ ?>
                            {{Form::input("text", "grupo", "Ningún grupo", array("class" => "form-control","placeholder"=>"Grupo",  "id"=>"field-7",'disabled'))}}
                           <? }else{
                             $grupo=Grupo::where('id','=',$clientes->grupo)->select('nombre')->first();
                             ?>
                             {{Form::input("text", "grupo", $grupo->nombre, array("class" => "form-control","placeholder"=>"Grupo",  "id"=>"field-7",'disabled'))}}
                          <?  }
                          ?>
                          </div>
                     </div>
					{{Form::close()}}


			</div>

		</div>

	</div>
</div>
<div class="row" id="aniadirdocumento" style="display:none;">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Documentos
				</div>

			</div>

			<div class="panel-body">

			<div class="form-group">
			 {{Form::open(array(
			                    "method" => "POST",
                                "action" => "ClientesController@subirdocumento",
			                    "files" => true,
                                 "role" => "form",
                                 "class" => "form-horizontal",
                                ))}}
                <label class="col-sm-3 control-label">Nombre del documento</label>
                <div class="col-sm-3">
                {{Form::input("text", "nombredocumento", null, array("class" => "form-control", "placeholder"=>"Nombre documento", "id"=>"field-1"))}}
                </div>
			    <div class="col-sm-5">
                {{Form::file('documento', ['class' => 'file-input-wrapper btn form-control file2 inline btn btn-primary' , 'data-label'=>'<i class="glyphicon glyphicon-file"></i> Buscar' ]);}}
			        {{Form::input("hidden", "_token", csrf_token())}}
			        {{Form::input("hidden", "id", $clientes->id)}}
			        </div>
			        <br>
                    {{Form::input("submit", null, "Subir documento", array("class" => "btn btn-default", "align"=>"center"))}}
                    {{Form::input("button", null, "Cancelar", array("class" => "btn btn-default", "align"=>"center", "onclick"=>"cancelar();"))}}


			        {{Form::close()}}


			    </div>

		</div>

	</div>
</div>
</div>


<div class="row" id="aniadircontacto" >
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
<div class="row" id="contactos">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Contactos
				</div>

			</div>

			<div class="panel-body">

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
                         	<?$contactos=Contactos::where('id_cli','=',$id_cli)->get();?>
            <?php foreach($contactos as $fila): ?>
            		<tr>
            			<td>{{$fila->id}}</td>
            			<td>{{$fila->nombre}}</td>
            			<td>{{$fila->apell1 . " " . $fila->apell2}} </td>
            			<td>{{$fila->telefono}}</td>
            			<td>{{HTML::mailto($fila->email)}}</td>
            			<td>
            				<a href="{{URL::route('clientes.eliminarcontacto', array('id' => $fila->id))}}" class="btn btn-danger btn-sm btn-icon icon-left delete-event" data-title="¿Me lo puedes confirmar?", data-content="¿Estás seguro de querer eliminar los datos?" onClick="return false;">
                      <i class="entypo-cancel"></i>
                      Eliminar
                    </a>
            			</td>
            		</tr>
            <?php endforeach; ?>
            	</tbody>
            </table>

		</div>

	</div>
</div>
</div>
<div class="row" id="documentos">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Documentos
				</div>

			</div>

			<div class="panel-body">

			    <?
                $documentos=Documentos::where('idcliente','=',$clientes->id)->get();
                if(Documentos::where('idcliente','=',$clientes->id)->count() == '0'){
                echo "No existen documentos.";
                }
			    $ruta="./documentos/".$clientes->id."/";
			    if(is_dir ($ruta)==true){
			    if ($dh = opendir($ruta)) {
                         while (($file = readdir($dh)) !== false) {
                             if ($file!="." && $file!=".."){


                                foreach ($documentos as $documento)
                                    {
                                    
                                   
                                    $rutabbdd=Funciones::sanear_string($documento->ruta);
                                    $archivo=Funciones::sanear_string(utf8_decode($file));


                                        if($rutabbdd == $archivo && $documento->idcliente == $clientes->id){
                                        echo "<div class='form-group'>";
                                        $date = new DateTime($documento->created_at);
                                        $fecha=$date->format('d/m/Y');

                                        echo "<div class='col-sm-6'><strong>Documento:</strong> ".$documento->nombredocumento." <br> <strong>Archivo:</strong> ".$file.  " <br> <strong>Creado: </strong>".$fecha." </div>
                                        <div class='col-sd-4'>
                                       <a href=".URL::route('clientes.descargar', array('id' => $documento->id))." class='btn btn-green btn-sm btn-icon icon-left'>
                                    <i class=entypo-download></i>
                                Descargar
                             </a>
                                        <a href=".URL::route('clientes.eliminardocumento', array('id' => $documento->id))." class='btn btn-danger btn-sm btn-icon icon-left delete-event' data-title='¿Me lo puedes confirmar?', data-content='¿Estás seguro de querer eliminar los datos?' onClick='return false;'>
                                    <i class=entypo-cancel></i>
                                Eliminar
                             </a></div><br>";
                                        echo "</div>";
                                        }
                                    }

                             }
                         }
                      closedir($dh);
                      }
                      echo "</div>";
                }
                      ?>


		</div>

	</div>
</div>
</div>
<script type="text/javascript">
function nuevodocumento() {
    document.getElementById('clientes').style.display = 'none';
    document.getElementById('contactos').style.display = 'none';
    document.getElementById('documentos').style.display = 'none';
    document.getElementById('aniadirdocumento').style.display  = 'block';
}
function nuevocontacto() {
    document.getElementById('clientes').style.display = 'none';
    document.getElementById('contactos').style.display = 'none';
    document.getElementById('documentos').style.display = 'none';
    document.getElementById('aniadircontacto').style.display  = 'block';
}
function cancelar() {
    document.getElementById('clientes').style.display = 'block';
    document.getElementById('contactos').style.display = 'block';
    document.getElementById('documentos').style.display = 'block';
    document.getElementById('aniadirdocumento').style.display  = 'none';
    document.getElementById('aniadircontacto').style.display  = 'none';
}
</script>
@stop


