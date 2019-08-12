<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>竞猜结果</title>
</head>
<body>
	<form action="" align="center">
	@csrf
	@foreach($data as $item)
		<table border='1'>
			<h1>竞猜结果</h1></br>
			<input type="text" value="{{$item->join_name}}">	 VS		<input type="text" value="{{$item->join_name1}}"></br>
			 <input type="text"  value="{{$item->result}}">
			<h2>结束竞猜时间 <input type="text" value="{{date("Y-m-d H:i:s",$item->end_time)}}"></h2></br>
		</table>
		@endforeach
	</form>
	<table>
	@foreach($info as $v)
	<tr>
		<td><h2>您的答案是{{$v->join_ying}}</h2>
	</tr></td>
	@endforeach
	<tr>
		<td>
			@if($item->result != $v->join_ying)
				<h1>对不起，没有猜中</h1>
			@elseif($item->result == $v->join_ying)
				<h1>恭喜您，猜中啦!请去前台领奖</h1>
			@endif
		</td>
	</tr>
	</table>
</body>
</html>