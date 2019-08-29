<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理课程</title>
</head>
<body>
	<form action="{{url('Kao/do_class')}}" menthod="post" align="center">
		第一节课：<select name="first_class">
						<option value="PHP">PHP</option>
						<option value="JAVA">JAVA</option>			
				  </select></br>
		第二节课：<select name="second_class">
						<option value="语文">语文</option>
						<option value="文言文">文言文</option>			
				  </select></br>
		第三节课：<select name="three_class">
						<option value="数学">数学</option>
						<option value="几何数学">几何数学</option>			
				  </select></br>
		第四节课：<select name="four_class">
						<option value="政治">政治</option>
						<option value="习近平谈治国理政">习近平谈治国理政</option>			
				  </select></br>
		<input type="submit" value="提交"></br>
	</form>
</body>
</html>