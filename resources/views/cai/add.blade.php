<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>参与竞猜</title>
</head>
<body>
	<form action="{{url('Cai/do_add')}}" method="post" align="center">
		@csrf
			<h1>我要竞猜</h1>
			@foreach($data as $item)
			<input type="hidden"  value="{{$item->c_id}}" name="c_id">
		<h1><input type="text" value="{{$item->c_name }}" name="join_name"></h1>  <h2>VS</h2>  <h1><input type="text" value="{{$item->c_name1 }}" name="join_name1"></h1>
	
			@endforeach
		<h1><input type="radio" name="join_ying" value="胜">胜   <input type="radio" name="join_ying" value="平">平     <input type="radio" name="join_ying" value="负">负</h1>
		<input type="submit" value="参与竞猜">

		
	</form>
</body>
</html>