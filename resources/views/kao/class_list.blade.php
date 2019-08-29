  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<meta charset="UTF-8">
  	<title>课程</title>
  </head>
  <body>
  	<h2>欢迎{{$name}}同学，下面是你的课程</h2>
  	<table border='1'>
  		<tr>
  			<td>第一节课</td>
  			<td>第二节课</td>
  			<td>第三节课</td>
  			<td>第四节课</td>
  		</tr>
  		@foreach($data as $v)
  		<tr>
  			<td>{{$v->first_class}}</td>
  			<td>{{$v->second_class}}</td>
  			<td>{{$v->three_class}}</td>
  			<td>{{$v->four_class}}</td>
  		</tr>
  		@endforeach
  	</table>
  </body>
  </html>