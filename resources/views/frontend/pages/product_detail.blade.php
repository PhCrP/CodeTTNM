@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
<meta name="description" content="{{$product_detail->summary}}">
<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$product_detail->title}}">
<meta property="og:image" content="{{$product_detail->photo}}">
<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','BuyPhone || Chi tiết sản phẩm')
@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{route('home')}}">Trang chủ<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="javascript:void(0);">Chi tiết sản phẩm</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Single -->
<section class="shop single section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-lg-6 col-12">
						<!-- Product Slider -->
						<div class="product-gallery">
							<!-- Images slider -->
							<div class="flexslider-thumbnails">
								<ul class="slides">
									@php
									$photo=explode(',',$product_detail->photo);
									// dd($photo);
									@endphp
									@foreach($photo as $data)
									<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
										<img src="{{$data}}" alt="{{$data}}">
									</li>
									@endforeach
								</ul>
							</div>
							<!-- End Images slider -->
						</div>
						<!-- End Product slider -->
					</div>
					<div class="col-lg-6 col-12">
						<div class="product-des">
							<!-- Description -->
							<div class="short">
								<h4>{{$product_detail->title}}</h4>
								<div class="rating-main">
									<ul class="rating">
										@php
										$rate=ceil($product_detail->getReview->avg('rate'))
										@endphp
										@for($i=1; $i<=5; $i++)
											@if($rate>=$i)
											<li><i class="fa fa-star"></i></li>
											@else
											<li><i class="fa fa-star-o"></i></li>
											@endif
											@endfor
									</ul>
									<a href="{{ route('under.development') }}" class="total-review">({{$product_detail['getReview']->count()}}) Đánh giá</a>
								</div>
								@php
								$after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
								@endphp
								<p class="price"><span class="discount">{{number_format($after_discount)}} VNĐ</span><s>{{number_format($product_detail->price)}} VNĐ</s> </p>
								<p class="description">{!!($product_detail->summary)!!}</p>
							</div>
							<!--/ End Description -->
							<!-- Size -->
							@if($product_detail->size)
							<div class="size">
								<div class="row">
									<div class="col-lg-6 col-12">
										<h4>Kích thước</h4>
										<select>
											@php
											$sizes=explode(',',$product_detail->size);
											// dd($sizes);
											@endphp
											@foreach($sizes as $size)
											<option>{{$size}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							@endif
							<!--/ End Size -->
							<!-- Product Buy -->
							<div class="product-buy">
								<form action="{{route('single-add-to-cart')}}" method="POST">
									@csrf
									<div class="quantity">
										<h6>Số lượng:</h6>
										<!-- Input Order -->
										<div class="input-group">
											<div class="button minus">
												<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
													<i class="ti-minus"></i>
												</button>
											</div>
											<input type="hidden" name="slug" value="{{$product_detail->slug}}">
											<input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1" id="quantity">
											<div class="button plus">
												<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
													<i class="ti-plus"></i>
												</button>
											</div>
										</div>
										<!--/ End Input Order -->
									</div>
									<div class="add-to-cart mt-4">
										<button type="submit" class="btn">Thêm vào giỏ hàng</button>
									</div>
								</form>

								<p class="cat">Danh mục<a href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a></p>
								@if($product_detail->sub_cat_info)
								<p class="cat mt-1">Danh mục phụ<a href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a></p>
								@endif
								<p class="availability">Stock : @if($product_detail->stock>0)<span class="badge badge-success">{{$product_detail->stock}}</span>@else <span class="badge badge-danger">{{$product_detail->stock}}</span> @endif</p>
							</div>
							<div class="default-social mt-3">
                                <h4 class="share-now">Chia sẻ:</h4>
                                <ul>
                                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                    <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
							<!--/ End Product Buy -->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="product-info">
							<div class="nav-main">
								<!-- Tab Nav -->
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá</a></li>
								</ul>
								<!--/ End Tab Nav -->
							</div>
							<div class="tab-content" id="myTabContent">
								<!-- Description Tab -->
								<div class="tab-pane fade show active" id="description" role="tabpanel">
									<div class="tab-single">
										<div class="row">
											<div class="col-12">
												<div class="single-des">
													<p>{!! ($product_detail->description) !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ End Description Tab -->
								<!-- Reviews Tab -->
								<div class="tab-pane fade" id="reviews" role="tabpanel">
									<div class="tab-single review-panel">
										<div class="row">
											<div class="col-12">

												<!-- Review -->
												<div class="comment-review">
													<div class="add-review">
														<h5>Thêm một đánh giá</h5>
														<p>Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu</p>
													</div>
													<h4>Đánh giá của bạn <span class="text-danger">*</span></h4>
													<div class="review-inner">
														<!-- Form -->
														@auth
														<form class="form" method="post" action="{{route('review.store',$product_detail->slug)}}">
															@csrf
															<div class="row">
																<div class="col-lg-12 col-12">
																	<div class="rating_box">
																		<div class="star-rating">
																			<div class="star-rating__wrap">
																				<input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
																				<label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
																				<input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
																				<label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
																				<input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
																				<label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
																				<input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
																				<label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
																				<input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																				<label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
																				@error('rate')
																				<span class="text-danger">{{$message}}</span>
																				@enderror
																			</div>
																		</div>
																	</div>
																</div>
																<div class="col-lg-12 col-12">
																	<div class="form-group">
																		<label>Write a review</label>
																		<textarea name="review" rows="6" placeholder=""></textarea>
																	</div>
																</div>
																<div class="col-lg-12 col-12">
																	<div class="form-group button5">
																		<button type="submit" class="btn">Nộp</button>
																	</div>
																</div>
															</div>
														</form>
														@else
														<p class="text-center p-5">
															Bạn cần phải <a href="{{route('login.form')}}" style="color:rgb(54, 54, 204)">Đăng nhập</a> HOẶC <a style="color:blue" href="{{route('register.form')}}">Đăng ký</a>

														</p>
														<!--/ End Form -->
														@endauth
													</div>
												</div>

												<div class="ratting-main">
													<div class="avg-ratting">
														{{-- @php 
																			$rate=0;
																			foreach($product_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
														<h4>{{ceil($product_detail->getReview->avg('rate'))}} <span>(Tổng thể)</span></h4>
														<span>Dựa trên {{$product_detail->getReview->count()}} Bình luận</span>
													</div>
													@foreach($product_detail['getReview'] as $data)
													<!-- Single Rating -->
													<div class="single-rating">
														<div class="rating-author">
															@if($data->user_info['photo'])
															<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
															@else
															<img src="{{asset('backend/img/avatar.png')}}" alt="Hồ sơ.jpg">
															@endif
														</div>
														<div class="rating-des">
															<h6>{{$data->user_info['name']}}</h6>
															<div class="ratings">

																<ul class="rating">
																	@for($i=1; $i<=5; $i++)
																		@if($data->rate>=$i)
																		<li><i class="fa fa-star"></i></li>
																		@else
																		<li><i class="fa fa-star-o"></i></li>
																		@endif
																		@endfor
																</ul>
																<div class="rate-count">(<span>{{$data->rate}}</span>)</div>
															</div>
															<p>{{$data->review}}</p>
														</div>
													</div>
													<!--/ End Single Rating -->
													@endforeach
												</div>

												<!--/ End Review -->

											</div>
										</div>
									</div>
								</div>
								<!--/ End Reviews Tab -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Shop Single -->

<!-- Start Most Popular -->
<div class="product-area most-popular related-product section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>Sản phẩm liên quan</h2>
				</div>
			</div>
		</div>
		<div class="row">
			{{-- {{$product_detail->rel_prods}} --}}
			<div class="col-12">
				<div class="owl-carousel popular-slider">
					@foreach($product_detail->rel_prods as $data)
					@if($data->id !==$product_detail->id)
					<!-- Start Single Product -->
					<div class="single-product">
						<div class="product-img">
							<a href="{{route('product-detail',$data->slug)}}">
								@php
								$photo=explode(',',$data->photo);
								@endphp
								<img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
								<img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
								<span class="price-dec">{{number_format($data->discount)}} % Off</span>
								{{-- <span class="out-of-stock">Hot</span> --}}
							</a>
							<div class="button-head">
								<div class="product-action">
									<a data-toggle="modal" data-target="#{{$data->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Mua sắm nhanh</span></a>
								</div>
								<div class="product-action-2">
									<a title="Add to cart" href="{{route('add-to-cart',$data->slug)}}">Thêm vào giỏ hàng</a>
								</div>
							</div>
						</div>
						<div class="product-content">
							<h3><a href="{{route('product-detail',$data->slug)}}">{{$data->title}}</a></h3>
							<div class="product-price">
								@php
								$after_discount=($data->price-(($data->discount*$data->price)/100));
								@endphp
								<span>{{number_format($after_discount)}} VNĐ</span>
								<span class="old">{{number_format($data->price)}} VNĐ</span>
							</div>

						</div>
					</div>
					<!-- End Single Product -->

					@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Most Popular Area -->


<!-- Modal -->
@foreach($product_detail->rel_prods as $data)
@if($data->id !== $product_detail->id)
<div class="modal fade" id="{{$data->id}}" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
			</div>
			<div class="modal-body">
				<div class="row no-gutters">
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<!-- Product Slider -->
						<div class="product-gallery">
							<div class="quickview-slider-active">
								@php
								$photo = explode(',', $data->photo);
								@endphp
								@foreach($photo as $image)
								<div class="single-slider">
									<img src="{{$image}}" alt="{{$image}}">
								</div>
								@endforeach
							</div>
						</div>
						<!-- End Product slider -->
					</div>
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
						<div class="quickview-content">
							<h2>{{$data->title}}</h2>
							<div class="quickview-ratting-review">
								<div class="quickview-ratting-wrap">
									<div class="quickview-ratting">
										@php
										$rate = DB::table('product_reviews')->where('product_id', $data->id)->avg('rate');
										$rate_count = DB::table('product_reviews')->where('product_id', $data->id)->count();
										@endphp
										@for($i = 1; $i <= 5; $i++)
											@if($rate>= $i)
											<i class="fa fa-star yellow"></i>
											@else
											<i class="fa fa-star"></i>
											@endif
											@endfor
									</div>
									<a href="{{ route('under.development') }}"> ({{$rate_count}} đánh giá của khách hàng)</a>
								</div>
								<div class="quickview-stock">
									@if($data->stock > 0)
									<span><i class="fa fa-check-circle-o"></i> {{$data->stock}} trong kho</span>
									@else
									<span><i class="fa fa-times-circle-o text-danger"></i> {{$data->stock}} hết hàng</span>
									@endif
								</div>
							</div>
							@php
							$after_discount = ($data->price - ($data->price * $data->discount) / 100);
							@endphp
							<h3><small><del class="text-muted">{{number_format($data->price)}} VNĐ</del></small> {{number_format($after_discount)}} VNĐ</h3>
							<div class="quickview-peragraph">
								<p>{!! html_entity_decode($data->summary) !!}</p>
							</div>
							@if($data->size)
							<div class="size">
								<div class="row">
									<div class="col-lg-6 col-12">
										<h5 class="title">Kích thước</h5>
										<select>
											@php
											$sizes = explode(',', $data->size);
											@endphp
											@foreach($sizes as $size)
											<option>{{$size}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							@endif
							<form action="{{route('single-add-to-cart')}}" method="POST">
								@csrf
								<div class="quantity">
									<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="hidden" name="slug" value="{{$data->slug}}">
										<input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
										<div class="button plus">
											<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>
									<!--/ End Input Order -->
								</div>
								<div class="add-to-cart">
									<button type="submit" class="btn">Thêm vào giỏ hàng</button>
								</div>
								<div class="default-social">
									<h4 class="share-now">Chia sẻ:</h4>
									<ul>
										<li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
										<li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
										<li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
										<li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
									</ul>
								</div>
							</form>
							<div class="default-social">
								<!-- ShareThis BEGIN -->
								<div class="sharethis-inline-share-buttons"></div>
								<!-- ShareThis END -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@endforeach
<!-- Modal end -->

@endsection
@push('styles')
<style>
	/* Rating */
	.rating_box {
		display: inline-flex;
	}

	.star-rating {
		font-size: 0;
		padding-left: 10px;
		padding-right: 10px;
	}

	.star-rating__wrap {
		display: inline-block;
		font-size: 1rem;
	}

	.star-rating__wrap:after {
		content: "";
		display: table;
		clear: both;
	}

	.star-rating__ico {
		float: right;
		padding-left: 2px;
		cursor: pointer;
		color: #4A90E2;
		font-size: 16px;
		margin-top: 5px;
	}

	.star-rating__ico:last-child {
		padding-left: 0;
	}

	.star-rating__input {
		display: none;
	}

	.star-rating__ico:hover:before,
	.star-rating__ico:hover~.star-rating__ico:before,
	.star-rating__input:checked~.star-rating__ico:before {
		content: "\F005";
	}
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

{{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
type:"POST",
data:{
_token:"{{csrf_token()}}",
quantity:quantity,
pro_id:pro_id
},
success:function(response){
console.log(response);
if(typeof(response)!='object'){
response=$.parseJSON(response);
}
if(response.status){
swal('success',response.msg,'success').then(function(){
document.location.href=document.location.href;
});
}
else{
swal('error',response.msg,'error').then(function(){
document.location.href=document.location.href;
});
}
}
})
});
</script> --}}

@endpush