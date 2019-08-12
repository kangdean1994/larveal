<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>标签列表</title>
</head>
<body>
	
	<form action="" align="center">
	<h1>标签列表</h1>
	<h2><a href="{{url('Wechat/get_user_list')}}">公众号粉丝列表</a></h2>
		<table border='1' align="center">
		
			<tr>
				<td>标签ID</td>
				<td>标签名</td>
				<td>标签下粉丝</td>
				<td>备注</td>
				<td>操作1</td>
				<td>操作2</td>
				<td>操作3</td>
			</tr>

			@foreach($data as $v)
			<tr>
				<td>{{$v['id']}}</td>
				<td>{{$v['name']}}</td>
				<td>{{$v['count']}}</td>
				<td>
				@if($v['id']==1)
				不能删除系统默认保留的标签
				@elseif($v['id']==2)
				不能删除系统默认保留的标签
				@elseif($v['id']==0)
				不能删除系统默认保留的标签
				@else
				<a href="{{url('Wechat/del_tag')}}?id={{$v['id']}}">删除</a>
				@endif
				</td>
				<td>
				@if($v['count']==0)
				该标签下没有粉丝
				@else
				<a href="{{url('Wechat/user_tag_list')}}?tagid={{$v['id']}}">标签下粉丝列表</a>
				@endif
				</td>

				<td>
				@if($v['id']==0)
				没有权限
				@elseif($v['id']==1)
				没有权限
				@elseif($v['id']==2)
				没有权限
				@else
				<a href="{{url('Wechat/get_user_list')}}?tag_id={{$v['id']}}">为粉丝打标签</a>
				@endif
				</td>
				<td><a href="{{url('Wechat/message')}}?tag_id={{$v['id']}}">推送消息</a></td>
			</tr>
			@endforeach
		</table>
	</form>
</body>
</html>