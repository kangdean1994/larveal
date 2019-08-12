<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>调研</title>
</head>
<body>
	<form action="{{url('Search/question_add')}}" method="post" align="center">
	@csrf
		调研问题: <input type="text" name="search_name"></br>
				<input type="submit" value="添加问题"></br>
	
	</form>
</body>
</html>