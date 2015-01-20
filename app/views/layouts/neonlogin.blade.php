<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

@yield('head')

	<link rel="stylesheet" href="/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.css"  id="style-resource-1">
	<link rel="stylesheet" href="/neon/assets/css/font-icons/entypo/css/entypo.css"  id="style-resource-2">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic"  id="style-resource-3">
	<link rel="stylesheet" href="/neon/assets/css/bootstrap.css"  id="style-resource-4">
	<link rel="stylesheet" href="/neon/assets/css/neon-core.css"  id="style-resource-5">
	<link rel="stylesheet" href="/neon/assets/css/neon-theme.css"  id="style-resource-6">
	<link rel="stylesheet" href="/neon/assets/css/neon-forms.css"  id="style-resource-7">
	<link rel="stylesheet" href="/neon/assets/css/custom.css"  id="style-resource-8">

	<script src="/neon/assets/js/jquery-1.11.0.min.js"></script>
<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="/neon/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->


	<!-- TS1413385116: Neon - Responsive Admin Template created by Laborator -->
</head>
<body class="page-body login-page login-form-fall">



<div class="login-container">

	<div class="login-header login-caret">

		<div class="login-content">

			<a href="{{URL::route('index')}}" class="logo">
				<img src="/neon/assets/images/logo2.png" width="240" alt="" />
			</a>

			@yield('frase')

		</div>

	</div>

	<div class="login-progressbar">
		<div></div>
	</div>

	<div class="login-form">

		@yield('contenido')

	</div>

</div>


	<script src="/neon/assets/js/gsap/main-gsap.js" id="script-resource-1"></script>
	<script src="/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
	<script src="/neon/assets/js/bootstrap.js" id="script-resource-3"></script>
	<script src="/neon/assets/js/joinable.js" id="script-resource-4"></script>
	<script src="/neon/assets/js/resizeable.js" id="script-resource-5"></script>
	<script src="/neon/assets/js/neon-api.js" id="script-resource-6"></script>
	<script src="/neon/assets/js/cookies.min.js" id="script-resource-7"></script>
	<script src="/neon/assets/js/jquery.validate.min.js" id="script-resource-8"></script>
	<script src="/neon/assets/js/neon-login.js" id="script-resource-9"></script>
	<script src="/neon/assets/js/neon-custom.js" id="script-resource-10"></script>
	<script src="/neon/assets/js/neon-demo.js" id="script-resource-11"></script>
	<script src="/neon/assets/js/neon-skins.js" id="script-resource-12"></script>


</body>
</html>