<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>地点</title>
</head>
<body>
	<form action="{{url('Car/do_address')}}" method="post" align="center">
	@csrf
		详细地址:<input type="text" name="address">
		<input type="submit" value="提交">
	</form>
</body>
</html>