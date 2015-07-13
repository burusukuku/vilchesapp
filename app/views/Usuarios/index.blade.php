@extends('layouts.neon')

@section('head')
<title>Ver Usuarios</title>
<meta name='description' content='Ver clientes'>
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
<div class="col-xs-6 col-left"><h3>Ver Usuarios</h3></div>
<div class="col-xs-6 col-right"></div><br><br>
</div>
@if(Session::has('exito'))
            <div class="exito mensajes">{{ Session::get('exito') }}</div>
     @endif
  <table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" style="width: 1415px;">
             	<thead>
             		<tr>
             			<th>Id</th>
             			<th>Nombre</th>
             			<th>Email</th>
             			<th>Activo</th>
             			<th>Tipo</th>
             			<th>Acciones</th>
             		</tr>
             	</thead>

             	<tbody>
<?php foreach($paginacion as $fila): ?>
		<tr>
			<td>{{$fila->id}}</td>
			<td>{{$fila->user}}</td>
			<td>{{$fila->email}}</td>
			<td><?php if($fila->activo==1){echo 'Si';}else{echo 'No';}?></td>
			<td>{{$fila->tipo}}</td>
			<td>
				{{-- Editar --}}
      <a href="{{URL::route('usuarios.editar', array('id' => $fila['id']))}}" class="btn btn-default btn-sm btn-icon icon-left">
          <i class="entypo-pencil"></i>
          Editar
        </a>

      {{--Eliminar--}}
      @if (Auth::user()->get()->id == $fila['id'])
      <a href="{{URL::route('usuarios.eliminar', array('id' => $fila['id']))}}" class="btn btn-danger btn-sm btn-icon icon-left delete-event" data-title="¿Me lo puedes confirmar?", data-content="¿Estás seguro de querer eliminar los datos?" onClick="return false;" disabled>
          <i class="entypo-cancel"></i>
          Eliminar
        </a>
      @else
      <a href="{{URL::route('usuarios.eliminar', array('id' => $fila['id']))}}" class="btn btn-danger btn-sm btn-icon icon-left delete-event" data-title="¿Me lo puedes confirmar?", data-content="¿Estás seguro de querer eliminar los datos?" onClick="return false;">
          <i class="entypo-cancel"></i>
          Eliminar
        </a>
      @endif
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>


<a href="{{URL::route('usuarios.crear')}}" class="btn btn-primary">
	<i class="entypo-plus"></i>
	Añadir Usuario
</a>

<br>
<br>
<br>

<script type="text/javascript">

var responsiveHelper;
var breakpointDefinition = {
  tablet: 1024,
  phone : 480
};
var tableContainer;
jQuery(document).ready(function($)
{
tableContainer = $("#table-3");
tableContainer.dataTable({
"oLanguage": {
"sEmptyTable": "No existen registros guardados!",
"sLengthMenu": "_MENU_ registros por página",
"sInfo":"Mostrando _START_ a _END_ de _TOTAL_ registros",
"sInfoEmpty":"No se muestra ningún registro"
},
"sPaginationType": "bootstrap",
"aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
"bStateSave": false,
"aaSorting":[[1,"asc"]],
"aoColumns": [
            			null,
            			null,
            			null,
            			null,
                        null,
            			{ "bSortable": false }
            		],


  // Responsive Settings
  bAutoWidth   : false,
  fnPreDrawCallback: function () {
    // Initialize the responsive datatables helper once.
    if (!responsiveHelper) {
      responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);
    }
  },
  fnRowCallback : function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
    responsiveHelper.createExpandIcon(nRow);
  },
  fnDrawCallback : function (oSettings) {
    responsiveHelper.respond();
  }
});
$(".dataTables_wrapper select").select2({
minimumResultsForSearch: -1
});
});
</script>

@stop


