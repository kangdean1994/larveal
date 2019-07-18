@extends('layout.admin_parent')
@section('admin')

<form class="layui-form" action="{{url('Admin/user_save')}}" method="post">
	@csrf
  <div class="layui-form-item">
    <label class="layui-form-label">管理员名称</label>
    <div class="layui-input-block">
      <input type="text" name="user_name"  class="layui-input">
    </div>
  </div>

 <div class="layui-form-item">
    <label class="layui-form-label">管理员密码</label>
    <div class="layui-input-block">
      <input type="password" name="user_pwd"  class="layui-input">
    </div>
  </div>

 
  <div class="layui-form-item">
    <label class="layui-form-label">管理员权限</label>
    <div class="layui-input-block">
     <input type="radio" name="user_state" value="1">超级管理员
     <input type="radio" name="user_state" value="2" checked>管理员
     <input type="radio" name="user_state" value="3">普通用户
     <input type="radio" name="user_state" value="4">黑名单
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