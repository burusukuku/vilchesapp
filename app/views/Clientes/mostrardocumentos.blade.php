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
					Datos Cliente
				</div>
				<div class="panel-options">
				     <a href="{{URL::route('clientes.editar', array('id' => $clientes->id))}}">
                       <button type="button" class="btn btn-default btn-sm btn-icon icon-left"><i class="entypo-pencil"></i>Editar</button>
                    </a>
                    <a href="{{URL::route('clientes.eliminar', array('id' => $clientes->id ))}}">
                    	  <button type="button" class="btn btn-danger btn-sm btn-icon icon-left"><i class="entypo-cancel"></i>Editar</button>
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

					    <label for="field-2" class="col-sm-2 control-label">Cif: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "dni", $clientes->cif, array("class" => "form-control", "placeholder"=>"Cif", "id"=>"field-2",'disabled'))}}
                        </div>
                    </div>
                    <div class="form-group">
						<label for="field-1" class="col-sm-2 control-label">Nombre: </label>
                        <div class="col-sm-3">
                        {{Form::input("text", "nombre", $clientes->nombre, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-1", 'disabled'))}}
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


