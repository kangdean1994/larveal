<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>详细地址</title>
</head>
<body>
	<form action="" align="center">
	@csrf
		<h1>经度：{{$lng}}</h1>
		<h1>维度：{{$lat}}</h1>
		<h1>地址：{{$data['address']}}</h1>
	</form>
</body>
</html>