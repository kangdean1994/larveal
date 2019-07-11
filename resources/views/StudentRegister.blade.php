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
				<h3>REGISTER</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12" action="{{url('StudentController/do_register')}}" method="post">
					@csrf
						<div class="input-field">
							<input type="text" class="validate" placeholder="NAME" required="" name="register_name">
						</div>
						<div class="input-field">
							<input type="email" placeholder="EMAIL" class="validate" required="" name="register_email">
						</div>
						<div class="input-field">
							<input type="password" placeholder="PASSWORD" class="validate" required="" name="register_pwd">
						</div>
						<input type="submit" class="btn button-default" value="REGISTER">
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
</body>
</html>