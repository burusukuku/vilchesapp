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
<div class="row">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Datos Personales
				</div>
				<div class="panel-options">
				    <a href="{{URL::route('clientes.editar', array('id' => $clientes->id))}}" class="btn btn-default btn-sm btn-icon icon-left">
                          <i class="entypo-pencil"></i>Editar
                    </a>
                    <a href="{{URL::route('clientes.eliminar', array('id' => $clientes->id ))}}" class="btn btn-danger btn-sm btn-icon icon-left">
                    	  <i class="entypo-cancel"></i>Eliminar
                    </a>
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                     "role" => "form",
                     "class" => "form-horizontal",
                    ))}}

					<div class="form-group">

					    <label for="field-2" class="col-sm-2 control-label">Dni: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "dni", $clientes->dni, array("class" => "form-control", "placeholder"=>"Dni", "id"=>"field-2",'disabled'))}}
                        </div>
                    </div>
                    <div class="form-group">
						<label for="field-1" class="col-sm-2 control-label">Nombre: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "nombre", $clientes->nombre, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-1", 'disabled'))}}
                        </div>
						 <label for="field-3" class="col-sm-2 control-label">Apellidos: </label>
                         <div class="col-sm-3">
                         {{Form::input("text", "apell1", $clientes->apell1 .' '. $clientes->apell2, array("class" => "form-control", "placeholder"=>"1º Apellido", "id"=>"field-3",'disabled'))}}
                         </div>

				    </div>

				    <div class="form-group">
                        <label for="field-5" class="col-sm-2 control-label">Teléfono: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "telefono", $clientes->telefono, array("class" => "form-control", "placeholder"=>"Teléfono", "id"=>"field-5",'disabled'))}}
                        </div>
                        <label for="field-6" class="col-sm-2 control-label">Fecha_nac: </label>
                        <div class="col-sm-3">
                        <?
                        $date = new DateTime($clientes->fecha_nac);
                        $fecha=$date->format('d/m/Y');
                        ?>
                        {{Form::input("text", "fecha_nac", $fecha, array("class" => "form-control","placeholder"=>"Fecha de nacimiento",  "id"=>"field-6", "data-mask"=>"date",'disabled'))}}
                        </div>
                    </div>
                     <div class="form-group">
                         <label for="field-5" class="col-sm-2 control-label">Correo: </label>
                         <div class="col-sm-3">
                         {{Form::input("text", "email", $clientes->email, array("class" => "form-control", "placeholder"=>"Correo", "id"=>"field-5",'disabled'))}}
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
					{{Form::close()}}


			</div>

		</div>

	</div>
</div>
<div class="row">
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
			    <label class="col-sm-3 control-label">Subir nuevo documento</label>
			    <div class="col-sm-5">


			        {{Form::file('documento', ['class' => 'file-input-wrapper btn form-control file2 inline btn btn-primary' , 'data-label'=>'<i class="glyphicon glyphicon-file"></i> Buscar' ]);}}
			        {{Form::input("hidden", "_token", csrf_token())}}
			        {{Form::input("hidden", "id", $clientes->id)}}
                    {{Form::input("submit", null, "Subir documento", array("class" => "btn btn-default"))}}


			        {{Form::close()}}

			    </div>
			    <?
			    $ruta="./documentos/".$clientes->id;
			    echo $ruta;
			    if ($dh = opendir($ruta)) {
                         while (($file = readdir($dh)) !== false) {
                            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
                            //mostraría tanto archivos como directorios
                            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file);
                            if (is_dir($ruta . $file) && $file!="." && $file!=".."){
                               //solo si el archivo es un directorio, distinto que "." y ".."
                               echo "<br>Directorio: $ruta$file";
                               listar_directorios_ruta($ruta . $file . "/");
                            }
                         }
                      closedir($dh);
                      }
                      ?>
			</div>

			</div>

		</div>

	</div>
</div>
@stop


