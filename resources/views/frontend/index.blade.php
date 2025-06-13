@extends('frontend.layouts.master')
@section('title','BuyPhone || Trang chủ')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
<section id="Gslider" class="carousel slide d-flex align-items-center justify-content-center" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
        @endforeach

    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key=>$banner)
        <div class="carousel-item {{(($key==0)? 'active' : '')}}">
            <a href="{{ $banner->url ?? route('product-grids') }}">
                <img class="first-slide" src="{{ $banner->photo }}" alt="First slide">
            </a>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Trước đó</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Tiếp theo</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->

<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid p-5">
        <div class="row">
            @php
            $category_lists=DB::table('categories')->where('status','active')->limit(4)->get();
            @endphp
            @if($category_lists)
            @foreach($category_lists as $cat)
            @if($cat->is_parent==1)
            <!-- Single Banner  -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-banner d-flex align-items-center justify-content-center">
                    @if($cat->photo)
                    <a href="{{ route('product-cat', $cat->slug) }}" class="border border-darklight rounded d-flex align-items-center justify-content-center">
                        <img class="p-1 w-75 h-75" src="{{$cat->photo}}" alt="{{$cat->photo}}">
                    </a>
                    @else
                    <a href="{{ route('home') }}" class="border border-darklight rounded d-flex align-items-center justify-content-center">
                        <img class="p-1 w-75 h-75" src="https://via.placeholder.com/600x370" alt="#">
                    </a>
                    @endif
                </div>
            </div>
            @endif
            <!-- /End Single Banner  -->
            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- Start Product Area -->
<div class="product-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Mặt hàng thịnh hành</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            @php
                            $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                            // dd($categories);
                            @endphp
                            @if($categories)
                            <button class="btn all-products" style="background:#333333;color:#fff;" data-filter="*">
                                Tất cả sản phẩm
                            </button>
                            @foreach($categories as $key=>$cat)

                            <button class="btn bg-focus" style="background:none;color:black;" data-filter=".{{$cat->id}}">
                                {{$cat->title}}
                            </button>
                            @endforeach
                            @endif
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>
                    <div class="tab-content isotope-grid" id="myTabContent">
                        <!-- Start Single Tab -->
                        @if($product_lists)
                        @foreach($product_lists as $key=>$product)
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->cat_id}}">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{ auth()->check() ? route('product-detail', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        // dd($photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        @if($product->stock<=0)
                                            <span class="out-of-stock">Sale out</span>
                                            @elseif($product->condition=='new')
                                            <span class="new">New</span
                                                @elseif($product->condition=='hot')
                                            <span class="hot">Hot</span>
                                            @else
                                            <span class="price-dec">{{number_format($product->discount)}}% Off</span>
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
                                    <div class="product-price">
                                        @php
                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <span>{{number_format($after_discount)}} VNĐ</span>
                                        <del style="padding-left:4%;">{{number_format($product->price)}} VNĐ</del>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!--/ End Single Tab -->
                        @endif

                        <!--/ End Single Tab -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Product Area -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Mặt hàng hot</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($product_lists as $product)
                    @if($product->condition=='hot')
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-img">
                            <a href="{{ auth()->check() ? route('product-detail', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">
                                @php
                                $photo=explode(',',$product->photo);
                                // dd($photo);
                                @endphp
                                <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                {{-- <span class="out-of-stock">Hot</span> --}}
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
                            <div class="product-price">
                                @php
                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                @endphp
                                <span>{{number_format($after_discount)}} VNĐ</span>
                                <del style="padding-left:4%;">{{number_format($product->price)}} VNĐ</del>
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

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Các mặt hàng mới nhất</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                    $product_lists=DB::table('products')->where('status','active')->orderBy('id','DESC')->limit(6)->get();
                    @endphp
                    @foreach($product_lists as $product)
                    <div class="col-md-4">
                        <!-- Start Single List  -->
                        <div class="single-list" style="border: none;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="list-image overlay">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        // dd($photo);
                                        @endphp
                                        <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <a href="{{ auth()->check() ? route('add-to-cart', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}" class="buy"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 no-padding">
                                    <div class="content">
                                        <h4 class="title"><a href="{{ auth()->check() ? route('product-detail', $product->slug) : route('login.form', ['redirect' => route('product-detail', $product->slug)]) }}">{{$product->title}}</a></h4>
                                        <p class="price with-discount">{{number_format($product->discount)}}% Off</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single List  -->
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Miễn phí vận chuyển</h4>
                    <p>Đơn hàng trên $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Trả hàng miễn phí</h4>
                    <p>Trả lại trong vòng 30 ngày</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Thanh toán an toàn</h4>
                    <p>Thanh toán an toàn 100%</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Giá tốt nhất</h4>
                    <p>Giá đảm bảo</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

@include('frontend.layouts.newsletter')

<!-- Modal -->
@if($product_lists)
@foreach($product_lists as $key=>$product)
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
                                            <h3><small><del class="text-muted">{{number_format($product->price)}} VNĐ</del></small>    {{number_format($after_discount)}} VNĐ </h3>
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
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=68178e73ccca0d0012c44767&product=inline-follow-buttons&source=platform" async="async"></script>
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=68178e73ccca0d0012c44767&product=inline-follow-buttons&source=platform" async="async"></script>
<style>
    /* Banner Sliding */
    #Gslider .carousel-inner {
        background: #000000;
        color: black;
        height: 550px;
    }

    #Gslider .carousel-inner img {
        pointer-events: auto;
        width: 100% !important;
        object-fit: cover;
        object-position: center;
        opacity: 0.8;
    }

    #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
    }

    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #4A90E2;
    }

    #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
    }

    #Gslider .carousel-inner a {
        display: block;
        text-decoration: none;
    }

    #Gslider .carousel-indicators {
        bottom: 70px;
    }

    .border-darklight:hover {
        opacity: 0.8;
        transition: all 0.3s ease-in-out;
    }

    .bg-focus {
        background: none;
        color: black;
        outline: none;
        transition: all 0.3s ease;
    }

    .bg-focus.active {
        background: #333333 !important;
        color: #fff !important;
        outline: none !important;
    }

    .all-products {
        background: #333333;
        color: #fff;
        outline: none;
        transition: all 0.3s ease;
    }

    .all-products.active {
        background: #333333 !important;
        color: #fff !important;
        outline: none !important;
    }

</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    /*==================================================================
        [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function() {
        $filter.on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({
                filter: filterValue
            });
        });

    });

    // init Isotope
    $(window).on('load', function() {
        var $grid = $topeContainer.each(function() {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });

    $('.all-products').addClass('active');

    $filter.on('click', 'button', function() {

        $filter.find('button').removeClass('active');
        $(this).addClass('active');
        if ($(this).hasClass('all-products')) {
            $('.all-products').css({
                'background': '#333333',
                'color': '#fff'
            });
        } else {
            $('.all-products').css({
                'background': 'none',
                'color': 'black'
            });
        }
        var filterValue = $(this).attr('data-filter');
        $topeContainer.isotope({
            filter: filterValue
        });
    });
</script>
<script>
    function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
</script>

@endpush