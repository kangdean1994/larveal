<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>单选</title>
</head>
<body>
	<form action="{{url('Search/dan_add')}}" method="post" align="center">
				@csrf
		题目：<input type="text" name="dan"></br>
		A: <input type="radio" name="dan1"> <input type="text" name="a"></br>
		B: <input type="radio" name="dan1"> <input type="text" name="b"></br>
		C: <input type="radio" name="dan1"> <input type="text" name="c"></br>
		D: <input type="radio" name="dan1"> <input type="text" name="d"></br>
		<input type="submit" value="生成调研">
	</form>
</body>
</html>