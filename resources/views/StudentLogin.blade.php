@extends('layout.parent')

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	@section('title','娃哈哈')
</head>
<body>
		@csrf
@section("pages section")
<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>LOGIN</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12" action="{{url('StudentController/do_login')}}" method="post">
					@csrf
						<div class="input-field">
							<input type="text" name="register_name" class="validate" placeholder="NAME" required="">
						</div>
						<div class="input-field">
							<input type="password" name="register_pwd" class="validate" placeholder="NAME" required="">
						</div>
						<a href=""><h6>Forgot Password ?</h6></a>
						<input type="submit" class="btn button-default" value="LOGIN">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
</body>
</html>