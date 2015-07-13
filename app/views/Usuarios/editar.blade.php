@extends('...layouts.neon')


@section('head')
<title>Editar Usuarios</title>
<meta name='description' content='Editar Usuarios'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')
<h1>Editar Usuarios</h1>
<div class="row">
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
					Datos Usuarios
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "UsuariosController@actualizar",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        "id" => "formulario-modal",
                                        ))}}
					<div class="form-group">
					    <label for="field-2" class="col-md-4 control-label">Nombre: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "user", $usuarios->user, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-2"))}}
                        </div>
                    </div>
                    <div class="form-group">
						<label for="field-1" class="col-md-4 control-label">Correo: </label>
						<div class="col-md-4">
				        {{Form::input("text", "email", $usuarios->email, array("class" => "form-control", "placeholder"=>"Correo", "id"=>"field-1"))}}
						</div>

				    </div>
            <?php if(Auth::user()->get()->id!=$usuarios->id){?>
				    <div class="form-group">
				    <label for="field-2" class="col-md-4 control-label">Tipo: </label>
                        <div class="col-md-4">
                        <select id="tipo" name="tipo" class="form-control">
                             <option value="{{$usuarios->tipo}}" selected>{{$usuarios->tipo}}</option>
                             <option value='Usuario'>Usuario</option>
                             <option value='Administrador'>Administrador</option>
                         </select>
                         </div>
                     </div>
                     
					<div class="form-group">
                        <label class="col-md-4 control-label">Activo</label>
                            <div class="col-md-4">
                                <div class="make-switch" data-text-label="<i class='entypo-user'></i>">
                                <?php if($usuarios->activo=='1'){?>
                                {{Form::checkbox("activo", '1', true )}}
                                <?php }else{?>
				                        {{Form::checkbox("activo", '1', false)}}
                                 <?php }?>
                                </div>
                            </div>
					</div>
					<?php } ?>
					<div class="form-group">
						<div class="col-sm-offset-5 col-sm-5">
						    {{Form::input("hidden", "_token", csrf_token())}}
						    {{Form::input("hidden", "id", $usuarios->id)}}
                            {{Form::input("button", null, "Guardar cambios", array("class" => "btn btn-default", "onclick"=>"jQuery('#editar').modal('show');"))}}
                        </div>
					{{Form::close()}}
				</form>

			</div>

		</div>

	</div>
</div>
@stop


