@extends('layout.admin_parent')
@section('admin')
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改</title>
</head>
<body>
	<form class="layui-form" action="{{url('Admin/do_update')}}" method="post" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="id" value="{{$data->id}}">
  <div class="layui-form-item">
    <label class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
      <input type="text" name="goods_name"   class="layui-input" value="{{$data->goods_name}}">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
      <input type="text" name="goods_price"  class="layui-input" value="{{$data->goods_price}}">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">是否热卖</label>
    <div class="layui-input-block">
     <input type="radio" name="is_top" value="{{$data->is_top}}" checked>是
     <input type="radio" name="is_top" value="{{$data->is_top}}">否
    </div>
  </div>
 
   <div class="layui-form-item">
    <label class="layui-form-label">图片</label>
    <div class="layui-input-block">
      <input type="file" name="goods_pic">
      <img src="{{$data->goods_pic}}" width="100px" height="100px">
    </div>
  </div>
 


  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn formdemo" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
</body>
</html>

@endsection