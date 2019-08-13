<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>二维码列表</title>
</head>
<body>
	<table border='1' align="center">
		<tr>
			<td>ID</td>
			<td>二维码链接</td>
			<td>生成二维码</td>
			<td>用户推广</td>
			<td>查看二维码</td>
		</tr>
		@foreach($data as $v)
		<tr>
			<td>{{$v->user_id}}</td>
			<td>
				@if($v->qrcode_url =='')
				未生成
				@else if
				{{$v->qrcode_url}}
				@endif
			</td>
			<td><a href="{{url('Wechat/seconds_qr')}}?id={{$v->user_id}}">生成二维码</a></td>
			<td><a href="">推广码</a></td>
			<td><a href="">查看二维码</a></td>
		</tr>
		@endforeach
	</table>
</body>
</html>