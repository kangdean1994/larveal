
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言板登录</title>
</head>
<body>
		<form action="{{url('Message/do_login')}}" method="post" align="center">
		@csrf
			<table>
				用户名：<input type="text" name="message_name"></br>
				密  码：<input type="password" name="message_pwd"></br>
				<input type="submit" value="登录">
			</table>
		</form>
</body>
</html>
























