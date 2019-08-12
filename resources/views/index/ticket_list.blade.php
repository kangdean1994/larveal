@extends('layout.cart_parent')
@section('cart')

<table>
 <form action="{{url('Index/ticket_list')}}" method="get">
   始发站<input type="text" name="go_station" value="{{$go_station}}">--终点站<input type="text" name="end_station" value="{{$end_station}}">
   <input type="submit" value="搜索">
 </form>

  <thead>
    <tr>
      <th>ID</th>
      <th>车次</th>
      <th>始发站</th>
      <th>终点站</th>
      <th>价格</th> 
      <th>票数</th>
      <th>购票时间</th>
      <th>发车时间</th>
      <th>操作</th>
    </tr> 
  </thead>
  <tbody>
  @foreach($list as $item)
    <tr>
      <td>{{$item->ticket_id}}</td>
      <td>{{$item->ticket_name}}</td>
      <td>{{$item->go_station}}</td>
      <td>{{$item->end_station}}</td>
      <td>{{$item->ticket_price}}</td>

      <td>
        @if($item->ticket_num>=100)
        有票
        @else($item->ticket_num==0)
        无票
        @endif
      </td>
      <td> {{date("Y-m-d H:i:s",$item->add_time)}}</td>
      <td> {{date("Y-m-d H:i:s",$item->add_time+3600)}}</td>
      <td><button>预约</button></td>
    </tr>
   
  @endforeach

  </tbody>
</table>

@endsection
