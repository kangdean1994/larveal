<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>留言板</title>
</head>
<body>
	<form action="{{url('Message/save')}}" method="post" align="center">
	@csrf
	<table>
		<h1>留言板</h1>
		<input type="text" name="content"></br>
		<input type="submit" value="提交">
	</table>
</form>



 	




<hr> -------------------- -------------------- -------------------- --------------------


  

<form action="{{url('Message/add')}}" method="get">
	<input type="text" name="search" value="{{$search}}">
	<input type="submit" value="搜索">
</form>
<h3 align="center">你访问了{{$num}}次</h3>
<table border="1">

  <thead>
    <tr>
      <th>ID</th>
      <th>姓名</th>
      <th>内容</th>
      <th>时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  @foreach($data as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>{{$item->name}}</td>
      <td>{{$item->content}}</td>
      <td>{{date("Y-m-d H:i:s",$item->add_time)}}</td>
      <td><a href="{{url('Message/delete')}}?id={{$item->id}}">删除</a></td>
    </tr>
 @endforeach
 <tr>
 		<td colspan="5">
 			{{ $data->appends(['search' => "$search"])->links() }}
 		</td>
 	</tr>
  </tbody>
</table>
</body>
</html>






















