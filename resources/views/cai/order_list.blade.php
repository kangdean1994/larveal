<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>列表</title>
</head>
<body>
	<table border="1" align="center">
		<tr>
			<td>ID</td>
			<td>竞猜国家</td>
			<td>备注</td>
			<td>参与时间</td>
			<td>结束时间</td>
		</tr>
		@foreach($data as $item)
		<tr>
			<td>{{$item->join_id}}</td>
			<td>{{$item->join_name}}VS{{$item->join_name1}}</td>
			<td>
				@if($times>$cai_time)
					<a href="{{url('Cai/look')}}?id={{$item->c_id}}">查看竞猜结果</a>
				@elseif($times<$cai_time )
					添加竞猜
				
				@endif
		
			</td>
			<td>{{date("Y-m-d H:i:s",$item->join_time)}}</td>
			<td>{{date("Y-m-d H:i:s",$cai_time)}}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>