@extends('...layouts.neon')


@section('head')
<title>Ficha Usuario</title>
<meta name='description' content='Ficha Usuario'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')

<h1>Ficha Usuario</h1>
<div class="row">
	<div class="col-md-12">
@if(Session::has('exito'))
        <div class="exito mensajes">{{ Session::get('exito') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
 @endif
<div class="panel panel-primary" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Datos Usuario
				</div>
				<div class="panel-options">
				    <a href="{{URL::route('usuarios.editar', array('id' => $usuarios->id))}}" class="btn btn-default btn-sm btn-icon icon-left">
                          <i class="entypo-pencil"></i>Editar
                    </a>
                    <a href="{{URL::route('usuarios.eliminar', array('id' => $usuarios->id ))}}" class="btn btn-danger btn-sm btn-icon icon-left">
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
                        <label for="field-2" class="col-md-4 control-label">Nombre: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "nombre", $usuarios->user, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-2", 'disabled'))}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="field-1" class="col-md-4 control-label">Correo: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "email", $usuarios->email, array("class" => "form-control", "placeholder"=>"Correo", "id"=>"field-1", 'disabled'))}}
                        </div>

                    </div>
                    <div class="form-group">
                    <label for="field-2" class="col-md-4 control-label">Tipo: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "tipo", $usuarios->tipo, array("class" => "form-control", "placeholder"=>"Tipo", "id"=>"field-1", 'disabled'))}}
                         </div>
                     </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">Activo</label>
                            <div class="col-md-4">
                                <div class="make-switch" data-text-label="<i class='entypo-user'></i>">
                                <? if($usuarios->active=='1'){?>
                                {{Form::checkbox("activo", '1', true, array('disabled'))}}
                                <?}else{?>
                                {{Form::checkbox("activo", '1', false, array('disabled'))}}
                                 <?}?>
                                </div>
                            </div>
                    </div>
					{{Form::close()}}


			</div>

		</div>

	</div>
</div>

@stop


