@extends('...layouts.neon')


@section('head')
<title>Enviar Boletin</title>
<meta name='description' content='Enviar Boletin'>
<meta name='keywords' content='palabras, clave'>
<meta name='robots' content='All'>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
@stop

@section('contenido')
<h1>Enviar Boletín</h1>
<div class="row">
	<div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

			<div class="panel-heading">
				<div class="panel-title">
					Datos Boletín
				</div>
			</div>

			<div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "BoletinesController@enviar",
                                        "role" => "form",
                                        "files" => true,
                                        "class" => "form-horizontal",
                                        "id" => "formulario-modal"
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
                         <label class="col-md-4 control-label">Subir Boletín</label>
          <div class="col-md-4">
                {{Form::file('boletin', ['class' => 'file-input-wrapper btn form-control file2 inline btn btn-primary' , 'data-label'=>'<i class="glyphicon glyphicon-file"></i> Buscar' ]);}}
          </div>
          </div>
          
          <script type="text/javascript">
                  jQuery(document).ready(function(){
                    $('#grupo').change(function(){
                      $.getJSON("{{ url('grupoexcluidos')}}",
                      { option: $(this).val() },
                      function(data) {
                          var item = $('#excluidos');
                                item.empty();
                                item.append("<option selected value='*' disabled>Elige un cliente</option>");
                        $.each(data, function(id, empresa) {
                          item.append("<option value='" + id + "'>" + empresa + "</option>");
                        });
                      });
                    });
                  });
                </script>
          <script type="text/javascript">
                  jQuery(document).ready(function(){
                    $('#grupo').change(function(){
                      $.getJSON("{{ url('grupoaniadidos')}}",
                      { option: $(this).val() },
                      function(data) {
                          var item = $('#cliente');
                                item.empty();
                                item.append("<option selected value='*' disabled>Elige un cliente</option>");
                        $.each(data, function(id, empresa) {
                          item.append("<option value='" + id + "'>" + empresa + "</option>");
                        });
                      });
                    });
                  });
                </script>

          <div class="form-group">
                 <label for="field-5" class="col-md-4 control-label">Seleccionar grupo: </label>
                 <div class="col-md-4">
                 <select id="grupo" name="grupo" class="form-control">
                 <option selected disabled>Elige un grupo</option>
                 <option value='*'>Todos</option>

                      {{$registros= Grupo::distinct()->groupBy('nombre')->get()}};

                      @foreach($registros as $registro)
                      echo "<option value='{{$registro->id}}'>{{$registro->nombre}}</option>";
                      @endforeach
                      
                 </select>
                 </div>
          </div>
         
          {{Form::close()}}

      
					
			</div>


<div class="row">
  <div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
        <i class="entypo-plus-circled"></i>  Enviar también a: 
        </div>
      </div>

      <div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "BoletinesController@aniadircliente",
                                        "role" => "form",
                
                                        "class" => "form-horizontal",
                                        "id" => "formulario-modal"
                                        ))}}

          <div class="form-group">
                  <label for="field-5" class="col-md-4 control-label">Seleccionar cliente: </label>
                 <div class="col-md-4">
                 <select id="cliente" name="cliente" class="form-control">
                 <option selected disabled>Elige un cliente</option>
                      
                 </select>
                 </div>
                 <div class="col-md-4">
                            {{Form::input("hidden", "_token", csrf_token())}}
                            {{Form::input("submit", null, "Añadir cliente", array("class" => "btn btn-default"))}}
                  </div>
                 

          {{Form::close()}}
          </div>
  
          @if( Boletines::where('num_boletin','=','0')->where('id_cli_ani','!=','0')->count() != '0')
          <?php // Los clientes añadidos tendrán en un principio: num_boletin = 0 y id_cli_ani != 0. Y cuando se envie el boletín se les cambiará el num_boletin al número incremental de los envios realizados. ?> 

  <table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" >
              <thead>
                <tr>
                  <th>Id</th>
                        <th>Nombre</th>
                        <th>Proporcion</th>
                        <th>Medida</th>
                        <th>Eliminar</th>
                </tr>
              </thead>

              <tbody>
              <?
              $registros= Boletines::where('num_boletin','=','0')->where('id_cli_ani','!=','0')->get();
              ?>

        @foreach($registros as $fila)
        <?$clienteaniadido= Clientes::find($fila->id_cli_ani);?>
    <tr>
      <td>{{$clienteaniadido->cif}}</td>
      <td>{{$clienteaniadido->empresa}}</td>
      <td>{{Grupo::find($clienteaniadido->grupo)->nombre}}</td>
      <td>{{$clienteaniadido->localidad}}</td>
      <td>
        <a href="{{URL::route("boletin.eliminarclienteani", array('id' => $fila['id_cli_ani']))}}" class="btn btn-danger btn-sm btn-icon icon-left">
          <i class="entypo-cancel"></i>
          Dejar de enviar
        </a>
      </td>
    </tr>
      @endforeach
  </tbody>
</table>
@endif
          
      </div>

    </div>

  </div>
</div>

<div class="row">
  <div class="col-md-12">
<div class="panel panel-primary" data-collapsed="0">

      <div class="panel-heading">
        <div class="panel-title">
        <i class="entypo-minus-circled"></i>  No enviar a: 
        </div>
      </div>

      <div class="panel-body">
                {{Form::open(array(
                                        "method" => "POST",
                                        "action" => "BoletinesController@aniadirclienteexc",
                                        "role" => "form",
                                        "class" => "form-horizontal",
                                        "id" => "formulario-modal"
                                        ))}}

          <div class="form-group">
                 <label for="field-5" class="col-md-4 control-label">Seleccionar cliente: </label>
                 <div class="col-md-4">
                 <select id="excluidos" name="excluidos" class="form-control">
                 <option disabled>Elige antes un grupo</option>
                 </select>
                 </div>
                 <div class="col-md-4">
                            {{Form::input("hidden", "_token", csrf_token())}}
                            {{Form::input("submit", null, "Excluir cliente", array("class" => "btn btn-default"))}}
                  </div>
          
          {{Form::close()}}
          </div>
          @if( Boletines::where('num_boletin','=','0')->where('id_cli_exc','!=','0')->count() != '0')
           <?php // Los clientes excluidos tendrán en un principio: num_boletin = 0 y id_cli_exc != 0. Y cuando se envie el boletín se les cambiará el num_boletin al número incremental de los envios realizados. ?> 

  <table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" >
              <thead>
                <tr>
                  <th>Id</th>
                        <th>Nombre</th>
                        <th>Proporcion</th>
                        <th>Medida</th>
                        <th>Eliminar</th>
                </tr>
              </thead>

              <tbody>
              <?
              $registros= Boletines::where('num_boletin','=','0')->where('id_cli_exc','!=','0')->get();?>
        @foreach($registros as $fila)
        <?
        $clienteaniadido= Clientes::find($fila->id_cli_exc);?>
    <tr>
      <td>{{$clienteaniadido->cif}}</td>
      <td>{{$clienteaniadido->empresa}}</td>
      <td>{{Grupo::find($clienteaniadido->grupo)->nombre}}</td>
      <td>{{$clienteaniadido->localidad}}</td>
      <td>
        <a href="{{URL::route("boletin.eliminarclienteexc", array('id' => $fila['id_cli_exc']))}}" class="btn btn-danger btn-sm btn-icon icon-left">
          <i class="entypo-cancel"></i>
          Volver a enviar
        </a>
      </td>
    </tr>
      @endforeach
  </tbody>
</table>
@endif
          
      </div>

    </div>

  </div>
</div>


<br><br>

 <div class="form-group">
              <div class="col-sm-offset-5 col-sm-5">
                {{Form::input("hidden", "_token", csrf_token())}}
                {{Form::input("button", null, "Enviar Boletin", array("class" => "btn btn-default", "onclick"=>"jQuery('#boletines').modal('show');"))}}
                         </div>
</div>

<br><br><br>





    </div>

  </div>
</div>

@stop


