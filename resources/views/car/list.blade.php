@extends('layout.admin_parent')
@section('admin')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>车库管理</title>
</head>
<body>
<form action="" align="center">	
	<table border="1">
		车库管理系统
		<tr>
			<td>ID</td>
			<td>车牌号</td>
			<td>入库时间</td>
			<td>车辆出库</td>
		</tr>
	@foreach($data as $item)
		<tr>
			<td>{{$item->c_id}}</td>
			<td>{{$item->car_name}}</td>
			<td>{{date("Y-m-d H:i:s",$item->add_time)}}</td>
			<td><a href="{{url('Car/update')}}?c_id={{$item->c_id}}">车辆出库</a></td>
		</tr>
	@endforeach
	</table>
</form>

</body>
</html>

@endsection