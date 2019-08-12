<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>消息推送</title>
</head>
<body>
<form action="{{url('Wechat/push_message')}}" method="get" align="center">

<input type="hidden" name="tagid" value="{{$tagid['tagid']}}">

	选择类型：<select name="type" id="">
		<option  name="text" value="1">文本消息</option>
		<option  name="img" value="2">图片消息</option>
	</select>
</br>
	输入内容：<textarea name="content" id="" cols="30" rows="10"></textarea></br>
			  
	<input type="submit" value="提交">
</form>
</body>
</html>