<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加</title>
</head>
<body>

	<form action="{{url('StudentController/do_goodsadd')}}" method="post" enctype="multipart/form-data">
		<center>
			@csrf
			图片<input type="file" name="goods_pic"></br>
			
			<input type="submit" name="" value="提交">
		</center>
	</form>
</body>
</html>