<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
	<form action="{{url('Wechat/fruit_do_update')}}" method="get" align="center">
	<input type="hidden" name="id" value="{{$data['id']}}">
		水果名称：<input type="text" name="fruit_name" value="{{$data['fruit_name']}}"></br>
		水果价格：<input type="text" name="fruit_price" value="{{$data['fruit_price']}}"></br>
		水果产地：<input type="text" name="fruit_address" value="{{$data['fruit_address']}}"></br>
		水果简述：<input type="text" name="fruit_desc" value="{{$data['fruit_desc']}}"></br>
		<input type="submit" value="修改">

	
	</form>
</body>
</html>