<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>水果列表</title>
</head>
<body>
<form action="{{url('Wechat/fruit_list')}}" method="get" align="center">
	<a href="{{url('Wechat/fruit_add')}}">加水果</a></br>
	<input type="text" name="fruit_name"><button>搜索</button>
</form>
	<table border='1' align="center">
		<tr>
			<td>标号</td>
			<td>水果名字</td>
			<td>水果价格</td>
			<td>水果产地</td>
			<td>水果简述</td>
			<td>水果操作</td>
		</tr>

		@foreach($data as $v)
			<tr>
				<td>{{$v->id}}</td>
				<td>{{$v->fruit_name}}</td>
				<td>{{$v->fruit_price}}</td>
				<td>{{$v->fruit_address}}</td>
				<td>{{$v->fruit_desc}}</td>
				<td>
				<a href="{{url('Wechat/fruit_del')}}?id={{$v->id}}">删除</a>|
				<a href="{{url('Wechat/fruit_update')}}?id={{$v->id}}">修改</a>
				</td>
			</tr>
		@endforeach
			<tr>
				<td colspan="6">
					{{ $data->links() }}
				</td>
			</tr>
	</table>

</body>
</html>