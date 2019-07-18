@extends('layout.order_parent')
@section('order')
<table border="1">
  <thead>
    <tr>
      <th>ID</th>
      <th>订单号</th>
      <th>价格</th>
      <th>订单状态</th>
      <th>下单时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  @foreach($data as $item)
    <tr>
      <td>{{$item->id}}</td>
      <td>{{$item->oid}}</td>
      <td>{{$item->pay_money}}</td>
  	  <td>
  	  	 @if($item->state==1)
      未支付
      @elseif($item->state==2)
     已支付
       @else($item->state==3)
      订单过期
      @endif
  	  </td>
      <td>{{date("Y-m-d H:i:s",$item->add_time)}}</td>
      <td><a href="{{url('pay')}}?id={{$item->id}}">去支付</a></td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection