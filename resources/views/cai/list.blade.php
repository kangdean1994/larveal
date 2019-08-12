<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>列表</title>
</head>
<body>
	<table border="1">
		<tr>
			<td>ID</td>
			<td>竞猜国家</td>
			<td>备注</td>
			<td>结束时间</td>
			<td>操作</td>
		</tr>
		@foreach($data as $item)
		<tr>
			<td>{{$item->c_id}}</td>
			<td>{{$item->c_name}}VS{{$item->c_name1}}</td>
			<td>
			<a href="{{url('Cai/add')}}?id={{$item->c_id}}">我要竞猜</a>
			</td>
			<td>{{date("Y-m-d H:i:s",$item->c_time)}}</td>
			 
			<td>
				<a href="{{url('Cai/delete')}}?id={{$item->c_id}}">删除</a>
			</td>
		</tr>
		@endforeach
	</table>
</body>
</html>