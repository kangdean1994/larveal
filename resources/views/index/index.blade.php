@extends('layout.index_parent')
@section('body')
@foreach($data as $item)
<div class="row">
	<div class="col s6">
		<div class="content">
			<a href="{{url('Index/list')}}?id={{$item->id}}"><img src="{{$item->goods_pic}}" alt=""></a>
			<h6><a href="">{{$item->goods_name}}</a></h6>
			<div class="price">
				{{$item->goods_price}} <span>$28</span>
			</div>
			<a href="{{url('Index/list')}}?id={{$item->id}}"><button class="btn button-default">ADD TO CART</a></button>
		</div>
	</div>
</div>

@endforeach
{{ $data->links() }}
@endsection

