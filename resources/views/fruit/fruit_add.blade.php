<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>水果</title>
</head>
<body>
	<form action="{{url('Wechat/fruit_do_add')}}" method="post" align="center">
	
		水果名称：<input type="text" name="fruit_name"></br>
		水果价格：<input type="text" name="fruit_price"></br>
		水果产地：<input type="text" name="fruit_address"></br>
		水果简述：<input type="text" name="fruit_desc"></br>
		<input type="submit" value="提交">

	
	</form>
</body>
</html>