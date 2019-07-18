@extends('layout.admin_parent')
@section('admin')

<form class="layui-form" action="{{url('Admin/save')}}" method="post" enctype="multipart/form-data">
	@csrf
  <div class="layui-form-item">
    <label class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
      <input type="text" name="goods_name" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
      <input type="text" name="goods_price" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>
 
   <div class="layui-form-item">
    <label class="layui-form-label">图片</label>
    <div class="layui-input-block">
      <input type="file" name="goods_pic"  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>
 
  <div class="layui-form-item">
    <label class="layui-form-label">商品库存</label>
    <div class="layui-input-block">
      <input type="text" name="goods_stock" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>
     
  <div class="layui-form-item">
    <label class="layui-form-label">是否热卖</label>
    <div class="layui-input-block">
     <input type="radio" name="is_top" value="1" checked>是
     <input type="radio" name="is_top" value="2">否
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn formdemo" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
@endsection