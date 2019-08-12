<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>车辆入库</title>
</head>
<body>
	<form action="{{url('Car/do_add')}}" method="post" align="center">
	@csrf
		<table>
			<h1>车辆入库</h1>
			车牌号:<input type="text" name="car_name">
			<input type="submit" value="车辆入库">
		</table>
	</form>
</body>
</html>