<!DOCTYPE html>
<html lang="es-ES">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	@yield('head')
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="SiGeCat - Sistema de Gestión integral para Catering" />
	<meta name="author" content="José Manuel Ruiz" />
	<meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
	<link rel="icon" href="./favicon.ico">
	<title>VilchesAPP</title>


	<link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"  id="style-resource-1">
	<link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css"  id="style-resource-2">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"  id="style-resource-3">
	<link rel="stylesheet" href="/neon/assets/css/bootstrap.css"  id="style-resource-4">
	<link rel="stylesheet" href="/neon/assets/css/neon.core.min.css"  id="style-resource-5">
	<link rel="stylesheet" href="/neon/assets/css/neon-core.css"  id="style-resource-9">
	<link rel="stylesheet" href="/neon/assets/css/neon-theme.css"  id="style-resource-6">
	<link rel="stylesheet" href="/neon/assets/css/neon-forms.css"  id="style-resource-7">
	<link rel="stylesheet" href="/neon/assets/css/custom.css"  id="style-resource-8">
	<link rel="stylesheet" href="/neon/assets/css/cajas.css"  id="style-resource-9">

<!--Para las cajas de mensajes-->
<script type="text/javascript" src="/neon/assets/js/jquery-1.2.6.js"></script>
<script type="text/javascript">
$(document).ready(function(){
      setTimeout(function(){ $(".mensajes").fadeOut(800).fadeIn(800).fadeOut(500).fadeIn(500).fadeOut(300);}, 3000);
});
</script>
<!-- Hasta aqui-->

	<script src="/neon/assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="/neon/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	

</head>
<body class="page-body <? if(Route::currentRouteName()=='index') echo "page-fade"; ?>" >

 <?php
 $vista= Route::currentRouteName();

              $secciones = array
                  (
                      'index' => 'opened',
                      'boletines' => '',
                      'clientes' => '',
                      'configuracion' => '',
                  );
              $subsecciones = array
                (
                    'index' => '',
                    'clientes.index' => '',
                    'clientes.crear' => '',
                    'boletines.index' => '',
                    'boletines.subir' => '',
                    'boletines.enviar' => '',
                    'configuracion.empresa' => '',
                    'configuracion.correo' => '',
                );

                $dividido = explode(".", $vista);

                 foreach ($secciones as $seccion => $valor){
                    if($seccion==$dividido[0]){
                        $secciones[$seccion]='opened';
                     }else{
                        $valor='';
                    }
                 }
                 foreach ($subsecciones as $subseccion => $valor){
                     if($subseccion==$vista){
                         $subsecciones[$subseccion]='active';
                      }else{
                         $valor='';
                     }
                  }




              ?>
<div class="page-container">	
	
	<div class="sidebar-menu">
		
			
		<header class="logo-env">
			
			<!-- logo -->
			<div class="logo">
				<a href="{{URL::route('index')}}">
					<img src="/neon/assets/images/logo2.png" width="250" alt="" />
				</a>
			</div>
			
						<!-- logo collapse icon -->
						
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
									
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
		</header>
				
		
		
				
		
				<ul id="main-menu" class="">
        <li class="<? echo $secciones['clientes']; ?>">
		<a href=""><i class="entypo-users"></i><span>Clientes</span></a>
            <ul>
            		<li>
            			<a href="{{URL::route('clientes.index')}}"><i class="entypo-search"></i><span>Ver Clientes</span></a>
            		</li>
            		<li>
                        <a href="{{URL::route('clientes.crear')}}"><i class="entypo-plus"></i><span>Añadir Cliente</span></a>
                    </li>
            </ul>
        </li>
        <li class="<? echo $secciones['boletines']; ?>">
        <a href=""><i class="entypo-book-open"></i><span>   Boletines</span></a>
                            <ul>
                <li>
                    <a href="http://demo.neontheme.com/layouts/layout-api/"><i class="entypo-search"></i><span>Ver Boletines</span></a>
                </li>
                <li>
                    <a href="http://demo.neontheme.com/layouts/layout-api/"><i class="entypo-plus"></i><span>Subir Boletín</span></a>
                </li>
                <li>
                    <a href="http://demo.neontheme.com/layouts/layout-api/"><i class="entypo-mail"></i><span>Envío Masivo de Boletines</span></a>
                </li>
            </ul>
        </li>
        <li class="<? echo $secciones['configuracion']; ?>">
            <a href="http://demo.neontheme.com/dashboard/main/"><i class="entypo-tools"></i><span>Configuración</span></a>
                <ul>
                    <li>
                        <a href="http://demo.neontheme.com/layouts/layout-api/"><i class="entypo-doc-text"></i><span>Datos de Empresa</span></a>
                    </li>
                    <li>
                        <a href="http://demo.neontheme.com/layouts/layout-api/"><i class="entypo-mail"></i><span>Configurar Correo</span></a>
                    </li>
                </ul>
            </li>
		</ul>
				
	</div>	
	<div class="main-content">

<div class="row">
	
	<!-- Profile Info and Notifications -->
	<div class="col-md-6 col-sm-8 clearfix">
		
		<ul class="user-info pull-left pull-none-xsm">
		
						<!-- Profile Info -->
			<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="/neon/assets/images/thumb-1@2x.png" alt="" class="img-circle" width="44" />
					{{Auth::user()->get()->user}}
				</a>
				
				<ul class="dropdown-menu">
					
					<!-- Reverse Caret -->
					<li class="caret"></li>
					
					<!-- Profile sub-links -->
					<li>
						<a href="http://demo.neontheme.com/extra/timeline/">
							<i class="entypo-user"></i>
							Editar Perfil
						</a>
					</li>
				</ul>
			</li>
		
		</ul>

	
	</div>
	
	
	<!-- Raw Links -->
	<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
		<ul class="list-inline links-list pull-right">
			

			
			<li>
				<a href="{{URL::route('salir')}}">
					Salir <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
		
	</div>
	
</div> <!--Barra Superior-->

<hr />



@yield ('contenido')







<!-- Footer -->
<footer class="main">
	
		<div class="pull-right">
		<strong>Vilches & Herrera asesores · 1980</strong>
	</div>
		
	&copy; 2015 <strong>Vilches & Herrera</strong>
	
</footer>	</div>
	

	</div>






<link rel="stylesheet" href="/neon/assets/js/datatables/responsive/css/datatables.responsive.css"  id="style-resource-1">
	<link rel="stylesheet" href="/neon/assets/js/select2/select2-bootstrap.css"  id="style-resource-2">
	<link rel="stylesheet" href="/neon/assets/js/select2/select2.css"  id="style-resource-3">

	<script src="/neon/assets/js/gsap/main-gsap.js" id="script-resource-1"></script>
	<script src="/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
	<script src="/neon/assets/js/bootstrap.js" id="script-resource-3"></script>
	<script src="/neon/assets/js/joinable.js" id="script-resource-4"></script>
	<script src="/neon/assets/js/resizeable.js" id="script-resource-5"></script>
	<script src="/neon/assets/js/neon-api.js" id="script-resource-6"></script>
	<script src="/neon/assets/js/cookies.min.js" id="script-resource-7"></script>
	<script src="/neon/assets/js/jquery.dataTables.min.js" id="script-resource-8"></script>
	<script src="/neon/assets/js/datatables/TableTools.min.js" id="script-resource-9"></script>
	<script src="/neon/assets/js/dataTables.bootstrap.js" id="script-resource-10"></script>
	<script src="/neon/assets/js/datatables/jquery.dataTables.columnFilter.js" id="script-resource-11"></script>
	<script src="/neon/assets/js/datatables/lodash.min.js" id="script-resource-12"></script>
	<script src="/neon/assets/js/datatables/responsive/js/datatables.responsive.js" id="script-resource-13"></script>

	<script src="/neon/assets/js/select2/select2.min.js" id="script-resource-14"></script>
    <script src="/neon/assets/js/jquery.inputmask.bundle.min.js" id="script-resource-15"></script>
	<script src="/neon/assets/js/neon-custom.js" id="script-resource-16"></script>
	<script src="/neon/assets/js/neon-demo.js" id="script-resource-17"></script>




	
</body>
</html>