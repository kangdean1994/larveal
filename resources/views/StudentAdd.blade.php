<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加</title>
</head>
<body>
	<div class="alert alert-danger" align="center">
			@if ($errors->any())
	            @foreach ($errors->all() as $error)
	             	<marquee style="color:blue"><h1>{{ $error }}</marquee></h1><br/>
	             	<marquee style="color:yellow"><h1>{{ $error }}</marquee></h1><br/>
	            @endforeach
			@endif
	</div>	
	<form action="{{url('StudentController/do_add')}}" method="post">
		<center>
			@csrf
			学生姓名<input type="text" name="name"></br>
			学生年龄<input type="text" name="age"></br>
			<input type="submit" name="" value="提交">
		</center>
	</form>
</body>
</html>