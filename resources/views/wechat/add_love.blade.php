<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加我的表白</title>
</head>
<body>
	
		<form action="{{url('Wechat/push_love')}}" method="get" align="center">
			<h4><a href="{{url('Wechat/love_list')}}">查看我的表白</a></h4>

				选择表白对象：</br>	
				@foreach($data as $v)
					<input type="checkbox">
					<input type="text"  value="{{$v->openid}}" name="openid">
					<input type="text" value="{{$v->nickname}}"></br>
				@endforeach
				真心话：<textarea name="content" cols="30" rows="10"></textarea></br>
					是否匿名表白：<input type="radio" name="one" checked value="是">是
								  <input type="radio" name="one"  value="否">否</br>
					<input type="submit" value="表白">

		</form>
</body>
</html>