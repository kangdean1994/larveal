<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加</title>
</head>
<body>
	<form action="{{url('Cai/do_result')}}" method="post" align="center">
	@csrf
		<table border='1'>
			<h1>竞猜结果</h1></br>
			@foreach($info as $item)
			<input type="hidden" name="c_id" value="{{$item->c_id}}">
			<input type="text" value="{{$item->c_name}}" name="join_name">	 VS		<input type="text" value="{{$item->c_name1}}" name="join_name1"></br>
			<h2>结束竞猜时间 <input type="text" value="{{date("Y-m-d H:i:s",$item->c_time)}}" name="end_time"></h2></br>
			@endforeach
			<input type="radio" name="result" value="胜">胜  <input type="radio" name="result" value="平">平 <input type="radio" name="result" value="负">负
			<h2><input type="submit" value="添加"></h2>
		</table>
	</form>
</body>
</html>