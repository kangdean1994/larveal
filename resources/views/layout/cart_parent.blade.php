<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="UTF-8">
	<title>Mstore - Online Shop Mobile Template</title>
	<meta name="viewport" content="width=device-width, initial-scale=1  maximum-scale=1 user-scalable=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="HandheldFriendly" content="True">

	<link rel="stylesheet" href="{{asset('/mstore/css/materialize.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/normalize.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/owl.carousel.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/owl.theme.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/owl.transitions.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/fakeLoader.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('/mstore/css/style.css')}}">
	
	<link rel="shortcut icon" href="{{asset('/mstore/img/favicon.png')}}">

</head>
<body>
	<div class="cart section">
		<div class="container">		
@section('cart')
			
@show
		</div>
	</div>
	<div id="fakeLoader"></div>
	
<script src="/jquery.js"></script>
	<script src="{{asset('/mstore/js/jquery.min.js')}}"></script>
	<script src="{{asset('/mstore/js/materialize.min.js')}}"></script>
	<script src="{{asset('/mstore/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('/mstore/js/fakeLoader.min.js')}}"></script>
	<script src="{{asset('/mstore/js/animatedModal.min.js')}}"></script>
	<script src="{{asset('/mstore/js/main.js"></script>

</body>
</html>