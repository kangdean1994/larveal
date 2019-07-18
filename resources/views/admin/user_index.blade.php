@extends('layout.admin_parent')
@section('admin')

<table class="layui-table"  cellpadding="20px" >
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>管理员ID</th>
      <th>管理员名称</th>
      <th>管理员权限</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
 @foreach($data as $item)
    <tr>
    <td>{{$item->user_id}}</td>
      <td>{{$item->user_name}}</td>
      <td>
      @if($item->user_state==2)
      管理员
      @elseif($item->user_state==3)
      普通用户
       @else($item->user_state==4)
      黑名单
      @endif
      </td>
     
      <td>{{date("Y-m-d H:i:s",$item->reg_time)}}</td>
      <td>
        <button>升级为管理员</button>|
        <button>拉入黑名单</button>
      </td>
    </tr>
 @endforeach
  <tr>
      <td colspan="5"> 
         {{ $data->links() }}
      </td>
    </tr>
   
  </tbody>
</table>
@endsection
