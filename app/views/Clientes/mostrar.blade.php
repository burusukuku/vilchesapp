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
@if(Session::has('exito'))
            <div class="exito mensajes">{{ Session::get('exito') }}</div>
     @endif
@if(Session::has('error'))
            <div class="error mensajes">{{ Session::get('error') }}</div>
     @endif
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


			        {{Form::close()}}


			    </div>
			    <?


			    $ruta="./documentos/".$clientes->id."/";
			    if(is_dir ($ruta)==true){
			    if ($dh = opendir($ruta)) {
                         while (($file = readdir($dh)) !== false) {
                             if ($file!="." && $file!=".."){


                                foreach ($documentos as $documento)
                                    {
                                        if($documento->ruta == $file && $documento->idcliente == $clientes->id){
                                        echo "<div class='form-group'>";
                                        $date = new DateTime($documento->created_at);
                                        $fecha=$date->format('d/m/Y');
                                        echo "<div class='col-sm-6'><strong>Documento:</strong> ".$documento->nombredocumento." <br> <strong>Archivo:</strong> ".$file.  " <br> <strong>Creado: </strong>".$fecha." </div>
                                        <div class='col-sm-2'><a href=".URL::route('clientes.descargar', array('id' => $documento->id ))."><button type='button' class='btn btn-success'> <i class='entypo-down'></i>Descargar </button></a></div>
                                        <div class='col-sd-4'><a href=".URL::route('clientes.eliminardocumento', array('id' => $documento->id ))."><button type='button' class='btn btn-white'> <i class='entypo-trash'></i>Eliminar </button></a></div><br>";
                                        echo "</div>";
                                        }
                                    }

                             }
                         }
                      closedir($dh);
                      }
                }
                      ?>




		</div>

	</div>
</div>
@stop


