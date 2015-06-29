@extends('layouts.neon')

@section('head')
<title>Editar configuración de correo</title>
<meta name='description' content='Editar configuración de correo'>
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
                    Mostrando configuración de correo
                </div>
                
            </div>

            <div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "ConfiguracionController@actualizarcorreo",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        "id" =>"formulario-modal"
                                        ))}}


          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Email: </label>
            <div class="col-md-4">
                {{Form::input("text", "email", $configuracion->email, array("class" => "form-control", "placeholder"=>"Email", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Host: </label>
            <div class="col-md-4">
                {{Form::input("text", "host", $configuracion->host, array("class" => "form-control", "placeholder"=>"Host", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Puerto: </label>
            <div class="col-md-4">
                {{Form::input("text", "puerto", $configuracion->puerto, array("class" => "form-control", "placeholder"=>"Puerto", "id"=>"field-1"))}}
            </div>
          </div>
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Usuario: </label>
            <div class="col-md-4">
                {{Form::input("text", "usuario", $configuracion->usuario, array("class" => "form-control", "placeholder"=>"Usuario", "id"=>"field-1"))}}
            </div>
          </div>
       
          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Contraseña: </label>
            <div class="col-md-4">
                {{Form::input("password", "password", $configuracion->password, array("class" => "form-control","data-typetoggle"=>"#show-password", "placeholder"=>"Contraseña", "id"=>"txtPassword"))}}
                
            </div>
            <div class="col-sm-offset-4 col-sm-5"><div class="checkbox"> <label><input id="chkShowPassword" type="checkbox" />Mostrar Contraseña</label> </div></div>
          </div>

          <div class="form-group">
            <label for="field-1" class="col-md-4 control-label">Remitente: </label>
            <div class="col-md-4">
                {{Form::input("text", "remitente", $configuracion->remitente, array("class" => "form-control", "placeholder"=>"Remitente", "id"=>"field-1"))}}
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

    <script type="text/javascript">
    $(function () {
        $("#chkShowPassword").bind("click", function () {
            var txtPassword = $("#txtPassword");
            if ($(this).is(":checked")) {
                txtPassword.after('<input onchange = "PasswordChanged(this);" id = "txt_' + txtPassword.attr("id") + '" type = "text"  class = "form-control" value = "' + txtPassword.val() + '" />');
                txtPassword.hide();
            } else {
                txtPassword.val(txtPassword.next().val());
                txtPassword.next().remove();
                txtPassword.show();
            }
        });
    });
    function PasswordChanged(txt) {
        $(txt).prev().val($(txt).val());
    }
</script>
    
@stop


