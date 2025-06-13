@extends('frontend.layouts.master')

@section('title','BuyPhone || Trang sản phẩm')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Trang chủ<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Sản phẩm</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Product Style -->
    <form action="#" method="POST">
        @csrf
        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Danh mục</h3>
                                    <ul class="categor-list">
										@php
											// $category = new Category();
											$menu=App\Models\Category::getAllParentWithChild();
										@endphp
										@if($menu)
										<li>
											@foreach($menu as $cat_info)
													@if($cat_info->child_cat->count()>0)
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
															<ul>
																@foreach($cat_info->child_cat as $sub_menu)
																	<li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
													@endif
											@endforeach
										</li>
										@endif
                                        {{-- @foreach(Helper::productCategoryList('products') as $cat)
                                            @if($cat->is_parent==1)
												<li><a href="{{route('product-cat',$cat->slug)}}">{{$cat->title}}</a></li>
											@endif
                                        @endforeach --}}
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Shop By Price -->
                                <div class="single-widget range">
                            <h3 class="title">Mua sắm theo giá</h3>
                            <div class="price-filter">
                                <div class="price-filter-inner">
                                    <div id="slider-range" data-min="0" data-max="1000000" data-currency=" VNĐ"></div>
                                    <div class="product_filter">
                                        <button class="filter_button">
                                        <a href="{{ route('under.development') }}">Lọc</a>
                                        </button>
                                        <div class="label-input">
                                            <span>Phạm vi:</span>
                                            <input style="" type="text" id="amount" readonly />
                                            <input type="hidden" name="price_range" id="price_range" />
                                            <div class="custom-price">
                                                <label for="custom-min">Giá tối thiểu:</label>
                                                <input type="number" id="custom-min" name="custom-min" min="0" placeholder="0 VNĐ"/>
                                                <label for="custom-max">Giá tối đa:</label>
                                                <input type="number" id="custom-max" name="custom-max" min="0" placeholder="1000000 VNĐ"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    <!--/ End Shop By Price -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                <div class="shop-shorter">
                                    <div class="single-shorter">
                                        <label>Sắp xếp theo:</label>
                                        <select class='sortBy' name='sortBy'>
                                            <option>Mặc định</option>
                                            <option>Tên</option>
                                            <option>Giá: Thấp đến Cao</option>
                                            <option>Giá: Cao đến Thấp</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            {{-- {{$products}} --}}
                            @if(count($products)>0)
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{ auth()->check() ? route('product-detail', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">
                                                    @php
                                                        $photo=explode(',',$product->photo);
                                                    @endphp
                                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    @if($product->discount)
                                                                <span class="price-dec">{{number_format($product->discount)}} % Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Mua sắm nhanh</span></a>
                                                        </div>
                                                    <div class="product-action-2">
                                                        <a href="{{ auth()->check() ? route('add-to-cart', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">Thêm vào giỏ hàng</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{ auth()->check() ? route('product-detail', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">{{$product->title}}</a></h3>
                                                @php
                                                    $after_discount=($product->price-($product->price*$product->discount)/100);
                                                @endphp
                                                <span>{{number_format($after_discount)}} VNĐ</span>
                                                <del style="padding-left:4%;">{{number_format($product->price)}} VNĐ</del>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                    <h4 class="text-warning" style="margin:100px auto;">Không có sản phẩm nào</h4>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{$products->appends($_GET)->links()}}
                            </div>
                          </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

    <!--/ End Product Style 1  -->

    <!-- Modal -->
    @if($products)
        @foreach($products as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
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
                                                        $photo=explode(',',$product->photo);
                                                    // dd($photo);
                                                    @endphp
                                                    @foreach($photo as $data)
                                                        <div class="single-slider">
                                                            <img src="{{$data}}" alt="{{$data}}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        <!-- End Product slider -->
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <div class="quickview-content">
                                            <h2>{{$product->title}}</h2>
                                            <div class="quickview-ratting-review">
                                                <div class="quickview-ratting-wrap">
                                                    <div class="quickview-ratting">
                                                        {{-- <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="yellow fa fa-star"></i>
                                                        <i class="fa fa-star"></i> --}}
                                                        @php
                                                            $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                            $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                        @endphp
                                                        @for($i=1; $i<=5; $i++)
                                                            @if($rate>=$i)
                                                                <i class="yellow fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <a href="{{ route('under.development') }}"> ({{$rate_count}} đánh giá của khách hàng)</a>
                                                </div>
                                                <div class="quickview-stock">
                                                    @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} trong kho</span>
                                                    @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} hết hàng</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                            @endphp
                                            <h3><small><del class="text-muted">{{number_format($product->price)}} VNĐ</del></small>    {{number_format($after_discount)}} VNĐ  </h3>
                                            <div class="quickview-peragraph">
                                                <p>{!! html_entity_decode($product->summary) !!}</p>
                                            </div>
                                            
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Kích thước</h5>
                                                        <select>
                                                            @php
                                                            $sizes=explode(',',$product->size);
                                                            // dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
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
                                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                                        <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1">
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
                                            <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->

@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button {
        /* height:20px; */
        text-align: center;
        background: #4A90E2;
        padding: 8px 16px;
        margin-top: 15px;
        color: white;
    }

    .filter_button:hover {
        background: #357ABD;
    }

    .filter_button:focus {
        outline: none;
    }

</style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
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
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
    $(document).ready(function() {
        /*----------------------------------------------------*/
        /*  Jquery UI slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt($("#slider-range").data('max')) || 1000000;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';

            // Lấy giá trị ban đầu từ price_range hoặc custom-min, custom-max
            let price_range = $("#price_range").val() ? $("#price_range").val().trim() : min_value + '-' + max_value;
            let price = price_range.split('-').map(val => parseInt(val) || 0);

            // Nếu có custom-min và custom-max, ưu tiên giá trị từ chúng
            const init_min = $("#custom-min").val() ? parseInt($("#custom-min").val()) : price[0];
            const init_max = $("#custom-max").val() ? parseInt($("#custom-max").val()) : price[1];

            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: [init_min, init_max],
                slide: function(event, ui) {
                    // Cập nhật amount với $ ở sau giá
                    $("#amount").val(ui.values[0] + currency + " - " + ui.values[1] + currency);
                    // Cập nhật price_range (không có $)
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    // Cập nhật custom-min và custom-max
                    $("#custom-min").val(ui.values[0]);
                    $("#custom-max").val(ui.values[1]);
                }
            });

            // Cập nhật giá trị ban đầu cho amount và price_range
            $("#amount").val($("#slider-range").slider("values", 0) + currency + " - " + $("#slider-range").slider("values", 1) + currency);
            $("#price_range").val($("#slider-range").slider("values", 0) + "-" + $("#slider-range").slider("values", 1));
        }

        // Đồng bộ custom-min và custom-max với thanh trượt
        $("#custom-min, #custom-max").on("input", function() {
            let minVal = parseInt($("#custom-min").val()) || 0;
            let maxVal = parseInt($("#custom-max").val()) || parseInt($("#slider-range").data('max'));

            // Đảm bảo min <= max
            if (minVal > maxVal) {
                minVal = maxVal;
                $("#custom-min").val(minVal);
            }

            // Cập nhật thanh trượt
            $("#slider-range").slider("values", [minVal, maxVal]);
            // Cập nhật amount (với $ ở sau giá) và price_range
            $("#amount").val(minVal + $("#slider-range").data('currency') + " - " + maxVal + $("#slider-range").data('currency'));
            $("#price_range").val(minVal + "-" + maxVal);
        });
    });
</script>
@endpush
