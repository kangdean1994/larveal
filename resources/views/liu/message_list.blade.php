<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>粉丝列表</title>
</head>
<body>
	<table align="center" border='1'>
		<tr>
			<td>用户</td>
			<td>操作</td>
		</tr>
		@foreach ($data as $v)
		<tr>
			<td>{{$v->nickname}}</td>
			<td><a href="{{url('Liu/go_message')}}?name={{$name}} && nickname={{$v->nickname}}">留言</a></td>
		</tr>
		@endforeach
	</table>
</body>
</html>