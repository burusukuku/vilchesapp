@extends('layouts.neon')

@section('head')
<title>Ver Clientes</title>
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
<div class="col-xs-6 col-left"><h3>Ver Clientes</h3></div>
<div class="col-xs-6 col-right"><p class="text-right"><a href="{{URL::route('clientespdf')}}" class="btn btn-red" target="_blank"><i class="entypo-download"></i> Descargar en PDF</a></p></div><br><br>
</div>
  <table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" style="width: 1415px;">
             	<thead>
             		<tr>
             			<th>Id</th>
             			<th>Empresa</th>
             			<th>Nombre</th>
             			<th>Apellidos</th>
             			<th>Email</th>
             			<th>Acciones</th>
             		</tr>
             	</thead>

             	<tbody>
<?php foreach($paginacion as $fila): ?>
		<tr>
			<td>{{$fila->id}}</td>
			<td>{{$fila->empresa}}</td>
			<td>{{$fila->nombre}}</td>
			<td>{{$fila->apell1 .' '. $fila->apell2}}</td>
			<td>{{$fila->email}}</td>
			<td>
				<a href="{{URL::route('clientes.editar', array('id' => $fila['id']))}}" class="btn btn-default btn-sm btn-icon icon-left">
					<i class="entypo-pencil"></i>
					Editar
				</a>
				<a href="{{URL::route('clientes.eliminar', array('id' => $fila['id'] ))}}" class="btn btn-danger btn-sm btn-icon icon-left">
				    <i class="entypo-cancel"></i>
				    Eliminar
				</a>


				<a href="{{URL::route('clientes.mostrar', array('id' => $fila['id'] ))}}" class="btn btn-info btn-sm btn-icon icon-left">
					<i class="entypo-info"></i>
					Ficha
				</a>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>


<a href="{{URL::route('clientes.crear')}}" class="btn btn-primary">
	<i class="entypo-plus"></i>
	Añadir Cliente
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


