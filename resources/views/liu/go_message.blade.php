<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言</title>
</head>
<body>


<form action="{{url('Liu/do_go_message')}}" method="post" align="center">

	留言人：<input type="text" name="uesr_name" ></br>
	<textarea name="content" cols="30" rows="10"></textarea></br>
	<input type="submit" value="留言">
</form>
</body>
</html>