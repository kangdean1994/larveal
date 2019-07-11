<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改</title>
</head>
<body>
	<form action="{{url('StudentController/do_update')}}" method="post">
		<table border='1'>
		@csrf
		<input type="hidden" name="id" value="{{$stident_info->id}}">
			<tr>
				<td>
					学生姓名<input type="text" name="name" value="{{$stident_info->name}}">
				</td>
			</tr>
			<tr>
				<td>
					学生年龄<input type="text" name="age"  value="{{$stident_info->age}}">
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="" value="修改">
				</td>
			</tr>
		</table>
	</form>
</body>
</html>