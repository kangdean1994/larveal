<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>详情</title>
</head>
<body>
<table>
	
		<marquee style="color:blue"><h6>头像：{{$data['headimgurl']}}</h6></marquee>
		<marquee style="color:pink"><h1>性别：@if($data['sex']==1) 男</h1></marquee>
			  @else
			  	<h1>女</h1>
			  @endif
		<marquee style="color:yellow"><h1>昵称：{{$data['nickname']}}</h1></marquee>
		<marquee style="color:green"><h1>城市：{{$data['city']}}</h1></marquee>
		<marquee style="color:red"><h1>省份：{{$data['province']}}</h1></marquee>
		<marquee style="color:black"><h4>openid:{{$data['openid']}}</h4></marquee>


</table>
</body>
</html>