@extends('layout.cart_parent')
@section('cart')
<div class="content">
				<div class="cart-1">
					<div class="row">
@foreach($data as $item)
		
						<div class="col s7">
							<img src="{{$item->goods_pic}}" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Name</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$item->goods_name}}</a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>BUY</h5>
						</div>
						<div class="col s7">
							<input value="{{$item->buy_num}}" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Price</h5>
						</div>
						<div class="col s7">
							<h5>{{$item->goods_price}}</h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Action</h5>
						</div>
						<div class="col s7">
							<h5><a href="{{url('Index/buy_delete')}}?id={{$item->id}}" class="fa fa-trash delete">删除</a></h5>
						</div>
			
			@endforeach
					</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h6>Total</h6>
						</div>
						<div class="col s7">

							<h5>{{$pricetotal}}</h5>
						</div>
				</div>
			<a href="{{url('Index/order_create')}}?total={{$pricetotal}}" class="btn button-default"><h3>确认购买</h3></a>
			<a href="{{url('Index/index')}}" class="btn button-default">Return to Index</a>


<script src="/jquery.js"></script>

<script type="text/javascript">
	$(function(){
		alert($);
		$(document).('delete','.click',function(){
			alert(111);
		})
	});
</script>
@endsection
