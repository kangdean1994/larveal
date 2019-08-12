@extends('layout.admin_parent')
@section('admin')
<form class="layui-form" action="{{url('Admin/ticket_save')}}" method="post">
	@csrf
  <div class="layui-form-item">
    <label class="layui-form-label">车次</label>
    <div class="layui-input-inline">
      <input type="text" name="ticket_name"   autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>


  <div class="layui-form-item">
    <label class="layui-form-label">出发站</label>
    <div class="layui-input-inline">
      <input type="text" name="go_station"   autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>

   <div class="layui-form-item">
    <label class="layui-form-label">到达站</label>
    <div class="layui-input-inline">
      <input type="text" name="end_station"   autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>



   <div class="layui-form-item">
    <label class="layui-form-label">价格</label>
    <div class="layui-input-inline">
      <input type="text" name="ticket_price"   autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>

    <div class="layui-form-item">
    <label class="layui-form-label">张数</label>
    <div class="layui-input-inline">
      <input type="text" name="ticket_num"   autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;

});
</script>
@endsection
