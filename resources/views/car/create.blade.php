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
	<table >
		车库管理系统
		<tr>
			<td>小区车位：400 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</td>	
		
			<td>剩余车位	{{$number}}	</td>
		
		</tr>

		<tr>
			<td>
				<a href="{{url('Car/add')}}">车辆入库</a>	
				&nbsp &nbsp &nbsp &nbsp &nbsp
			</td>
			<td>
			
				<a href="{{url('Car/list')}}">车辆出库</a>
		
			</td>
		</tr>


		
	</table>
</form>

</body>
</html>

@endsection