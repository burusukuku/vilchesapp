@extends('layouts.neon')

@section('head')
<title>Mostrar Configuración</title>
<meta name='description' content='Mostrar Configuracion'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')
<div class="row">
	<div class="col-md-12">
@if(Session::has('exito'))
    <div class="exito mensajes">{{ Session::get('exito') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
@if(Session::has('error'))
    <div class="error mensajes">{{ Session::get('error') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif
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
          Datos de configuración del correo
        </div>
        <div class="panel-options">
                    <a href="{{URL::route('configuracion.editarcorreo')}}" class="btn btn-default btn-sm btn-icon icon-left">
                          <i class="entypo-pencil"></i>Editar
                    </a>
        </div>
      </div>

      <div class="panel-body">
                {{Form::open(array(
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        ))}}
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Email: </label>
            <div class="col-md-4">
                {{Form::input("text", "email", $configuracion->email, array("class" => "form-control", "placeholder"=>"Email", "id"=>"field-1", "disabled"=>"true"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Host: </label>
            <div class="col-md-4">
                {{Form::input("text", "host", $configuracion->host, array("class" => "form-control", "placeholder"=>"Host", "id"=>"field-1", "disabled"=>"true"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Puerto: </label>
            <div class="col-md-4">
                {{Form::input("text", "puerto", $configuracion->puerto, array("class" => "form-control", "placeholder"=>"Puerto", "id"=>"field-1", "disabled"=>"true"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Usuario: </label>
            <div class="col-md-4">
                {{Form::input("text", "usuario", $configuracion->usuario, array("class" => "form-control", "placeholder"=>"Usuario", "id"=>"field-1", "disabled"=>"true"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Contraseña: </label>
            <div class="col-md-4">
                {{Form::input("password", "password", $configuracion->password, array("class" => "form-control", "placeholder"=>"Contraseña", "id"=>"field-1", "disabled"=>"true"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Remitente: </label>
            <div class="col-md-4">
                {{Form::input("text", "remitente", $configuracion->remitente, array("class" => "form-control", "placeholder"=>"Remitente", "id"=>"field-1", "disabled"=>"true"))}}
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
          Probar correo
        </div>
      </div>

      <div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "ConfiguracionController@envioprueba",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        ))}}
          
          <div class="form-group">
          <label for="field-1" class="col-md-4 control-label">Enviar Correo de prueba a: </label>
             <div class="col-md-4">
                {{Form::input("text", "correo", null, array("class" => "form-control", "placeholder"=>"Correo Destino", "id"=>"field-1"))}}                          
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-5 col-md-4">
                {{Form::input("hidden", "_token", csrf_token())}}
                {{Form::input("submit",null, "Enviar correo de prueba", array("class" => "btn btn-default"))}}
                        </div>
          {{Form::close()}}
        

      </div>

    </div>
    </div>
    </div>
    </div>
    </div>
@stop


