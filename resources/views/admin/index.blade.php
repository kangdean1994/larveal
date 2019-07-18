@extends('layout.admin_parent')
@section('admin')

<form action="{{url('Admin/index')}}" method="get">
	<input type="text" name="search" value="{{$search}}">
	<input type="submit" value="搜索">
</form>
<h3 align="center">你访问了{{$num}}次</h3>
<table class="layui-table"  cellpadding="20px" >
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>商品名ID</th>
      <th>商品名称</th>
      <th>商品图片</th>
      <th>商品价格</th>
      <th>商品库存</th>
      <th>是否热卖</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
 @foreach($data as $item)
    <tr>
    <td>{{$item->id}}</td>
      <td>{{$item->goods_name}}</td>
      <td>
		<img src="{{$item->goods_pic}}" width="50px" height="50px">
      </td>
      <td>{{$item->goods_price}}</td>
      <td>{{$item->goods_stock}}</td>
      <td>{{$item->is_top}}</td>
      <td>{{date("Y-m-d H:i:s",$item->add_time)}}</td>
      <td>
      	<a href="{{url('Admin/delete')}}?id={{$item->id}}">删除</a>|
		<a href="{{url('Admin/update')}}?id={{$item->id}}">修改</a>
      </td>
    </tr>
 @endforeach
 	<tr>
 		<td colspan="7">
 			{{ $data->appends(['search' => "$search"])->links() }}
 		</td>
 	</tr>
  </tbody>
	
</table>
@endsection
