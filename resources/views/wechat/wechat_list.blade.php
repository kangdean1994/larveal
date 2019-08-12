<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>刷新粉丝列表</title>
</head>
<body>
	<form action="{{url('Wechat/set_tag')}}" method="get" >
	<input type="hidden" name="tag_id" value="{{$tag_id}}">
	<h1 align="center"><a href="{{url('Wechat/add_tag')}}">添加标签</a></h1>

	<h1 align="center"><input type="submit" value="贴标签"></h1>
	<table border='1' align="center">
	
		<tr>
			<td>选择</td>
			<td>ID</td>
			<td>openid</td>
			<td>昵称</td>
			<!-- <td>关注时间</td>
			<td>是否关注</td> -->
			<td>操作</td>
		</tr>

		@foreach($data as $v)
		<tr>
			<td><input type="checkbox" name="x_box[]" value="{{$v->openid}}"></td>
			<td>{{$v->id}}</td>
			<td>{{$v->openid}}</td>
			<td>{{$v->nickname}}</td>
			<!-- <td>{{date("Y-m-d H:i:s",$v->add_time)}}</td>
			<td>
				@if($v->subscribe==1)
					已关注
				@else
					未关注
				@endif
			</td> -->
			<td><a href="{{url('Wechat/pro')}}?openid={{$v->openid}}">详情</a></td>
			
		</tr>
		@endforeach

	</table>
	
	</form>
</body>
</html>