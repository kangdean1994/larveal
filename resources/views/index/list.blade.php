@extends('layout.list_parent')
@section('wishlist')
				<div class="cart-1">
					<div class="row">
						<div class="col s7">
							<img src="{{$info->goods_pic}}" width="600px" heifht="600px">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Name</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$info->goods_name}}</a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Stock Status</h5>
						</div>
						<div class="col s7">
							<h5>In Stock</h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Price</h5>
						</div>
						<div class="col s7">
							<h5>{{$info->goods_price}}</h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>Action</h5>
						</div>
						<div class="col s7">
							<h5><i class="fa fa-trash"></i></h5>
						</div>
					</div>
					<div class="row">
						<div class="col 12">
							<a href="{{url('Index/cart_save')}}?id={{$info->id}}" class="btn button-default">SEND TO CART</a>
						</div>
					</div>
				</div>
@endsection
