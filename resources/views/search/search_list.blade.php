<table border='1'>

  <thead>
    <tr>
      <th>ID</th>
      <th>项目名称</th>
      <th>备注</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  @foreach($data as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>{{$item->search_name}}</td>
      <td>
        <a href="{{url('Search/search_order')}}?id={{$item->id}}">启用</a>
      </td>
      <td>
      <a href="{{url('Search/question_delete')}}?id={{$item->id}}">删除</a>
      </td>
    </tr>
   @endforeach
  </tbody>
</table>