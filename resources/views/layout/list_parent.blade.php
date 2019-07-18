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

	
	<link rel="shortcut icon" href="{{asset('/mstore/css/img/favicon.png')}}">

</head>
<body>



	<!-- side nav right-->
	<div class="side-nav-panel-right">
		<ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
			<li class="profil">
				<img src="img/profile.jpg" alt="">
				<h2>John Doe</h2>
			</li>
			<li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
			<li><a href="about-us.html"><i class="fa fa-user"></i>About Us</a></li>
			<li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
			<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
			<li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
		</ul>
	</div>
	<!-- end side nav right-->

	<!-- navbar bottom -->
	<div class="navbar-bottom">
		<div class="row">
			<div class="col s2">
				<a href="index.html"><i class="fa fa-home"></i></a>
			</div>
			<div class="col s2">
				<a href="wishlist.html"><i class="fa fa-heart"></i></a>
			</div>
			<div class="col s4">
				<div class="bar-center">
					<a href="#animatedModal" id="cart-menu"><i class="fa fa-shopping-basket"></i></a>
					<span>2</span>
				</div>
			</div>
			<div class="col s2">
				<a href="contact.html"><i class="fa fa-envelope-o"></i></a>
			</div>
			<div class="col s2">
				<a href="#animatedModal2" id="nav-menu"><i class="fa fa-bars"></i></a>
			</div>
		</div>
	</div>
	
	@section('wishlist')
	<!-- wishlist -->
	
	@show

	<!-- end wishlist -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	
	<!-- footer -->
	<div class="footer">
		<div class="container">
			<div class="about-us-foot">
				<h6>Mstore</h6>
				<p>is a lorem ipsum dolor sit amet, consectetur adipisicing elit consectetur adipisicing elit.</p>
			</div>
			<div class="social-media">
				<a href=""><i class="fa fa-facebook"></i></a>
				<a href=""><i class="fa fa-twitter"></i></a>
				<a href=""><i class="fa fa-google"></i></a>
				<a href=""><i class="fa fa-linkedin"></i></a>
				<a href=""><i class="fa fa-instagram"></i></a>
			</div>
			<div class="copyright">
				<span>© 2017 All Right Reserved</span>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- scripts -->
	<script src="/jquery.js"></script>

	<script src="{{asset('/mstore/js/materialize.min.js')}}"></script>
	<script src="{{asset('/mstore/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('/mstore/js/fakeLoader.min.js')}}"></script>
	<script src="{{asset('/mstore/js/animatedModal.min.js')}}"></script>
	<script src="{{asset('/mstore/js/main.js')}}"></script>
</body>
</html>
