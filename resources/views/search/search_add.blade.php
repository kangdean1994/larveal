<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>调研</title>
</head>
<body>
	<form action="{{url('Search/do_add')}}" method="post" align="center">
	@csrf
		
		问题选项: <input type="radio" name="search_one" value="单选">单选    <input type="radio" name="search_one" value="复选">复选
									<input type="submit" value="添加问题"></br>
	
	</form>
</body>
</html>