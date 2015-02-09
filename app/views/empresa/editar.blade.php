@extends('layouts.neon')

@section('head')
<title>Editar Empresa</title>
<meta name='description' content='Editar Empresa'>
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
                    Mostrando empresa: {{$empresa->nombre}}
                </div>
                <div class="panel-options">
                    <a href="{{URL::route('empresa.editar', array('id' => $empresa->id))}}" class="btn btn-default btn-sm btn-icon icon-left">
                          <i class="entypo-pencil"></i>Editar
                    </a>
        </div>
            </div>

            <div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "EmpresaController@actualizar",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        "id" =>"formulario-modal"
                                        ))}}

                    <div class="form-group">
                      <div class="col-md-4">
                          <img src="http://placehold.it/200x150" alt="...">
                      </div>
                    </div>
          <div class="form-group">
                <label for="field-2" class="col-md-4 control-label">Cif: </label>
            <div class="col-md-4">
            {{Form::input("text", "cif", $empresa->cif, array("class" => "form-control", "placeholder"=>"Cif", "id"=>"field-2"))}}
                </div>
            </div>
                    <div class="form-group">
                        <label for="field-1" class="col-md-4 control-label">Nombre: </label>
                        <div class="col-md-4">
                        {{Form::input("text", "nombre", $empresa->nombre, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-1"))}}
                        </div>
                    </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Email: </label>
            <div class="col-md-4">
                {{Form::input("text", "email", $empresa->email, array("class" => "form-control", "placeholder"=>"Email", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Dirección: </label>
            <div class="col-md-4">
                {{Form::input("text", "direccion", $empresa->direccion, array("class" => "form-control", "placeholder"=>"Dirección", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Localidad: </label>
            <div class="col-md-4">
                {{Form::input("text", "localidad", $empresa->localidad, array("class" => "form-control", "placeholder"=>"Nombre", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Provincia: </label>
            <div class="col-md-4">
                {{Form::input("text", "provincia", $empresa->provincia, array("class" => "form-control", "placeholder"=>"Localidad", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Código Postal: </label>
            <div class="col-md-4">
                {{Form::input("text", "cp", $empresa->cp, array("class" => "form-control", "placeholder"=>"Código Postal", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Teléfono: </label>
            <div class="col-md-4">
                {{Form::input("text", "telefono", $empresa->telefono, array("class" => "form-control", "placeholder"=>"Teléfono", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-5">
                            {{Form::input("hidden", "_token", csrf_token())}}
                            {{Form::input("button", null, "Guardar cambios", array("class" => "btn btn-default", "onclick"=>"jQuery('#editar').modal('show');"))}}
                        </div>
                    {{Form::close()}}
                </form>
            </div>

        </div>

    </div>
    </div>

    
@stop


