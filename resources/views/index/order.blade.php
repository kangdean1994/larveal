@extends('layout.order_parent')
@section('order')
	<form>
				<div class="row">
					<div class="col s12">
						<ul class="collapsible" data-collapsible="accordion">
							<li>
							</li>
							<li>
								<div class="collapsible-header"><h5>1 - 收货地址</h5></div>
								<div class="collapsible-body">
									<div class="billing-information">
										<form action="#">
											<div class="input-field">
												<h5>Name*</h5>
												<input type="text" class="validate" name="order_name">
											</div>
										
											<div class="input-field">
												<h5>Address*</h5>
												<input type="text" class="validate" name="order_address">
											</div>
					
											<div class="input-field">
												<h5>Phone*</h5>
												<input type="number" class="validate" name="order_phone">
											</div>
										</form>
									</div>
								</div>
							</li>
							<li>
							</li>
							<li>
								<div class="collapsible-header"><h5>2 - 支付方式</h5></div>
								<div class="collapsible-body">
									<div class="payment-mode">
				
										<form action="#" class="checkout-radio">
												<div class="input-field">
													<input type="radio" class="with-gap" id="bank-transfer" name="order_pay" value="1">
													<label for="bank-transfer"><span>支付宝</span></label>
												</div>
												<div class="input-field">
													<input type="radio" class="with-gap" id="cash-on-delivery" name="order_pay" value="2">
													<label for="cash-on-delivery"><span>微信</span></label>
												</div>
												<div class="input-field">
													<input type="radio" class="with-gap" id="online-payments" name="order_pay" value="3">
													<label for="online-payments"><span>银行卡</span></label>
												</div>
										</form>
									</div>
								</div>
							</li>
						</form>
							<li>
								<div class="collapsible-header"><h5>3 - 订单详情</h5></div>
								<div class="collapsible-body">
									<div class="order-review">
										<div class="row">
											<div class="col s12">
												<div class="cart-details">
												@foreach($data as $item)
													<div class="col s5">
														<div class="cart-product">
															<h5>Image</h5>
														</div>
													</div>
													
												
														<div class="cart-product">
															<img src="{{$item->goods_pic}}" width="20px" height="20px">
														</div>
													

												</div>
												<div class="divider"></div>
												<div class="cart-details">
													<div class="col s5">
														<div class="cart-product">
															<h5>Name</h5>
														</div>
													</div>
													<div class="col s7">
														<div class="cart-product">
															<a href="">{{$item->goods_name}}</a>
														</div>
													</div>
												</div>
												<div class="divider"></div>
												<div class="cart-details">
													<div class="col s5">
														<div class="cart-product">
															<h5>Buy_num</h5>
														</div>
													</div>
													<div class="col s7">
														<div class="cart-product">
															<input type="text" value="{{$item->buy_num}}">
														</div>
													</div>
												</div>
												@endforeach
												<div class="cart-details">
													
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="order-review final-price">
										<div class="row">
											<div class="col s12">
												<div class="cart-details">
												</div>
												<div class="cart-details">
												</div>
												<div class="cart-details">
													<div class="col s8">
														<div class="cart-product">
															<h5>Total</h5>
														</div>
													</div>
													<div class="col s4">
														<div class="cart-product">
															<span>$31.00</span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<a href="{{url('Index/order_save')}}" class="btn button-default button-fullwidth">CONTINUE</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
@endsection