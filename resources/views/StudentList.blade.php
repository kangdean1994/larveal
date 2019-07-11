<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>列表</title>
</head>

<form action="{{url('StudentController/index')}}" method="get">

    <input type="text" name="search" value="{{$search}}">
    <input type="submit" value="搜索">
</form>

 <table border='1'>
    <tr>
        <th>ID</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>时间</th>
        <th>操作</th>
       
    </tr>
       @foreach($student as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->name}}</td>
            <td>{{$item->age}}</td>
            <td>{{date("Y-m-d H:i:s",$item->create_time)}}</td>
             <td>
             <a href="{{url('StudentController/update')}}?id={{$item->id}}">修改</a>|
             <a href="{{url('StudentController/delete')}}?id={{$item->id}}">删除</a>
             </td>

        </tr>
        @endforeach
    <tr>
        <td colspan='4'>
             {{ $student->appends(['search' => "$search"])->links() }}
        </td>
    </tr>
           
      
</table>
</body>
</html>