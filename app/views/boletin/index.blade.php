@extends('layouts.neon')

@section('head')
<title>Ver Boletines Enviados</title>
<meta name='description' content='Ver Boletines'>
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
<div class="col-xs-6 col-left"><h3>Ver Boletines Enviados</h3></div>
</div>
  <table class="table table-bordered datatable" id="table-3" aria-describedby="table-3_info" style="width: 1415px;">
             	<thead>
             		<tr>
             			<th>Id</th>
             			<th>Boletin</th>
                  <th>Grupo enviado</th>
             			<th>Fecha</th>
             		</tr>
             	</thead>

             	<tbody>
             <? $grupos=Grupo::all();?>	
<?php foreach($paginacion as $fila): ?>
		<tr>
			<td>{{$fila->id}}</td>
			<td>{{$fila->ruta}}</td>
      @if($fila->grupo<1)
        <td>Todos</td>
        @else
        @foreach($grupos as $grupo)
          @if($grupo->id == $fila->grupo)
            <td>{{$grupo->nombre}}</td>
          @endif
       @endforeach 
       @endif
			<td>{{$fila->created_at}}</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>


<a href="{{URL::route('boletin.crear')}}" class="btn btn-primary">
	<i class="entypo-plus"></i>
	Enviar Boletín
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


