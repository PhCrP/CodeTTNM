@extends('frontend.layouts.master')
@section('title', 'Trang giỏ hàng')
@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ route('home') }}">Trang chủ<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="">Giỏ hàng</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Shopping Giỏ hàng -->
<div class="shopping-cart section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Shopping Summery -->
				<table class="table shopping-summery">
					<thead>
						<tr class="main-hading">
							<th>SẢN PHẨM</th>
							<th>TÊN</th>
							<th class="text-center">GIÁ ĐƠN VỊ</th>
							<th class="text-center">SỐ LƯỢNG</th>
							<th class="text-center">TỔNG TIỀN</th>
							<th class="text-center"><i class="ti-trash remove-icon"></i></th>
						</tr>
					</thead>
					<tbody id="cart_item_list">
						<form action="{{ route('cart.update') }}" method="POST">
							@csrf
							@php
							$cartItems = auth()->check() ? \App\Models\Cart::where('user_id', auth()->id())->get() : collect([]);
							@endphp
							@if($cartItems->isNotEmpty())
							@foreach($cartItems as $key => $cart)
							<tr>
								@php
								$photo = explode(',', $cart->product['photo']);
								@endphp
								<td class="image" data-title="No"><img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"></td>
								<td class="product-des" data-title="Description">
									<p class="product-name"><a href="{{ route('product-detail', $cart->product['slug']) }}" target="_blank">{{ $cart->product['title'] }}</a></p>
									<p class="product-des">{!! $cart['summary'] !!}</p>
								</td>
								<td class="price" data-title="Price"><span>{{ number_format($cart['price']) }} VNĐ</span></td>
								<td class="qty" data-title="Qty">
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{ $key }}]">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="text" name="quant[{{ $key }}]" class="input-number" data-min="1" data-max="100" value="{{ $cart->quantity }}">
										<input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
										<div class="button plus">
											<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{ $key }}]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>
								</td>
								<td class="total-amount cart_single_price" data-title="Total"><span class="money">{{ number_format($cart['amount']) }} VNĐ</span></td>
								<td class="action" data-title="Remove">
									<a href="javascript:void(0)" class="delete-cart-item" data-id="{{ $cart->id }}" data-title="{{ $cart->product->title }}"><i class="ti-trash remove-icon"></i></a>
								</td>
							</tr>
							@endforeach
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td class="float-right">
									<button class="btn float-right" type="submit">Cập nhật</button>
								</td>
							</tr>
							@else
							<tr>
								<td colspan="6" class="text-center">
									<div class="empty-cart-message">
										<img src="/photos/1/cart_empty.png" alt="Giỏ hàng rỗng">
										<h4>Giỏ hàng của bạn đang trống!</h4>
										<a href="{{ route('product-grids') }}" class="btn" style="color: #FFFFFF; font-size: 13px; border-radius:4px;">Khám phá sản phẩm</a>
									</div>
								</td>
							</tr>
							@endif
						</form>
					</tbody>
				</table>
				<!--/ End Shopping Summery -->
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<!-- Total Amount -->
				<div class="total-amount">
					<div class="row">
						<div class="col-lg-8 col-md-5 col-12">
							<div class="left">
								@if($cartItems->isNotEmpty())
								<div class="coupon">
									<form action="{{ route('coupon-store') }}" method="POST">
										@csrf
										<input name="code" placeholder="Nhập mã giảm giá của bạn">
										<button class="btn">Áp dụng</button>
									</form>
								</div>
								@endif
							</div>
						</div>
						<div class="col-lg-4 col-md-7 col-12">
							<div class="right">
								<ul>
									<li class="order_subtotal" data-price="{{ $cartItems->isNotEmpty() ? \App\Models\Cart::where('user_id', auth()->id())->sum('amount') : 0 }}">
										Tổng tiền<span>{{ number_format($cartItems->isNotEmpty() ? \App\Models\Cart::where('user_id', auth()->id())->sum('amount') : 0) }} VNĐ</span>
									</li>
									@if(session()->has('coupon') && $cartItems->isNotEmpty())
									<li class="coupon_price" data-price="{{ Session::get('coupon')['value'] }}">
										Bạn tiết kiệm<span>{{ number_format(Session::get('coupon')['value']) }} VNĐ</span>
									</li>
									@else
									<li class="coupon_price" data-price="0">
										Bạn tiết kiệm<span>0 VNĐ</span>
									</li>
									@endif
									@php
									$total_amount = $cartItems->isNotEmpty() ? \App\Models\Cart::where('user_id', auth()->id())->sum('amount') : 0;
									$coupon_value = session()->has('coupon') && $cartItems->isNotEmpty() ? Session::get('coupon')['value'] : 0;
									$total_amount = $total_amount - $coupon_value;
									@endphp
									<li class="last" id="order_total_price">
										Bạn trả tiền<span>{{ number_format($total_amount) }} VNĐ</span>
									</li>
								</ul>
								@if($cartItems->isNotEmpty())
								<div class="button5">
									<a href="#" class="btn">Thanh toán</a>
									<a href="{{ route('product-grids') }}" class="btn">Tiếp tục mua sắm</a>
								</div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<!--/ End Total Amount -->
			</div>
		</div>
	</div>
</div>
<!--/ End Shopping Cart -->

<!-- Start Shop Services Area -->
<section class="shop-services section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-rocket"></i>
					<h4>Miễn phí vận chuyển</h4>
					<p>Đơn hàng trên $100</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-reload"></i>
					<h4>Trả lại miễn phí</h4>
					<p>Trả lại trong vòng 30 ngày</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-lock"></i>
					<h4>Thanh toán an toàn</h4>
					<p>Thanh toán an toàn 100%</p>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<div class="single-service">
					<i class="ti-tag"></i>
					<h4>Giá tốt nhất</h4>
					<p>Giá đảm bảo</p>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Shop Services -->

<!-- Start Shop Newsletter -->
@include('frontend.layouts.newsletter')
<!-- End Shop Newsletter -->

@endsection
@push('styles')
<style>
	/* Styling for empty cart message */
	.empty-cart-message {
		padding: 40px 20px;
		text-align: center;
		background: #f8f9fa;
		border-radius: 4px;
		margin: 20px 0;
	}

	.empty-cart-message h4 {
		font-size: 24px;
		color: #333;
		margin-bottom: 25px;
	}

	.empty-cart-message img {
		width: 100px !important;
		height: 100px !important;
		margin-bottom: 20px;
	}

	.empty-cart-message .btn-primary {
		background-color: #4A90E2;
		border: none;
		padding: 10px 20px;
		font-size: 16px;
		transition: background-color 0.3s ease;
	}

	.empty-cart-message .btn-primary:hover {
		background-color: #357ABD;
	}

	/* Styling for delete confirmation modal */
	#deleteConfirmModal.custom-modal {
		position: fixed !important;
		top: 0 !important;
		left: 0 !important;
		width: 100% !important;
		height: 100% !important;
		background: rgba(0, 0, 0, 0.6) !important;
		z-index: 10000 !important;
		display: none !important;
		/* Ẩn mặc định */
		flex-direction: column !important;
		justify-content: center !important;
		align-items: center !important;
		animation: fadeIn 0.3s ease-in-out !important;
	}

	#deleteConfirmModal.custom-modal.show {
		display: flex !important;
		/* Hiển thị khi có class show */
	}

	#deleteConfirmModal .custom-modal-content {
		background: #ffffff !important;
		border-radius: 4px !important;
		max-width: 400px !important;
		width: 90% !important;
		box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2) !important;
		overflow: hidden !important;
		transform: scale(0.9) !important;
		animation: scaleUp 0.3s ease-in-out forwards !important;
	}

	#deleteConfirmModal .custom-modal-header {
		display: flex !important;
		justify-content: space-between !important;
		align-items: center !important;
		background: #2c2c2c !important;
		color: #ffffff !important;
		padding: 12px 20px !important;
		font-size: 18px !important;
		font-weight: 600 !important;
		border-bottom: 1px solid #e0e0e0 !important;
	}

	#deleteConfirmModal .custom-modal-close {
		cursor: pointer !important;
		font-size: 24px !important;
		line-height: 1 !important;
		transition: color 0.2s ease !important;
	}

	#deleteConfirmModal .custom-modal-close:hover {
		color: #ff4d4d !important;
	}

	#deleteConfirmModal .custom-modal-body {
		padding: 20px !important;
		font-size: 16px !important;
		color: #333333 !important;
		line-height: 1.5 !important;
		text-align: center !important;
	}

	#deleteConfirmModal .custom-modal-footer {
		display: flex !important;
		justify-content: flex-end !important;
		padding: 12px 20px !important;
		background: #f9f9f9 !important;
		border-top: 1px solid #e0e0e0 !important;
		gap: 10px !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn {
		padding: 10px 20px !important;
		border-radius: 4px !important;
		font-size: 14px !important;
		font-weight: 500 !important;
		border: none !important;
		cursor: pointer !important;
		transition: background-color 0.2s ease, transform 0.1s ease !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn:active {
		transform: scale(0.95) !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn-confirm {
		background: #d32f2f !important;
		color: #ffffff !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn-confirm:hover {
		background: #b71c1c !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn-cancel {
		background: #4a90e2 !important;
		color: #ffffff !important;
	}

	#deleteConfirmModal .custom-modal-footer .btn-cancel:hover {
		background: #357abd !important;
	}

	/* Hiệu ứng animation */
	@keyframes fadeIn {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}

	@keyframes scaleUp {
		from {
			transform: scale(0.9);
		}

		to {
			transform: scale(1);
		}
	}

	/* Responsive cho màn hình nhỏ */
	@media (max-width: 576px) {
		#deleteConfirmModal .custom-modal-content {
			max-width: 320px !important;
			width: 95% !important;
		}

		#deleteConfirmModal .custom-modal-header {
			font-size: 16px !important;
			padding: 10px 15px !important;
		}

		#deleteConfirmModal .custom-modal-body {
			font-size: 14px !important;
			padding: 15px !important;
		}

		#deleteConfirmModal .custom-modal-footer .btn {
			padding: 8px 15px !important;
			font-size: 13px !important;
		}
	}
</style>
@endpush
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Hiển thị modal thông báo thành công/lỗi nếu có
        $('#successModal').fadeIn();
        $('#errorModal').fadeIn();
        $('#deleteModal').fadeIn();

        // Vô hiệu hóa giới hạn tối thiểu của input-number (nếu dùng plugin)
        $('.input-number').each(function() {
            $(this).attr('data-min', '0'); // Cho phép giá trị 0
        });

        // Xử lý sự kiện click nút xóa
        $('.delete-cart-item').on('click', function() {
            var cartId = $(this).data('id');
            var productTitle = $(this).data('title');

            // Gửi yêu cầu để hiển thị modal xác nhận
            window.location.href = '{{ url("cart/confirm-delete") }}/' + cartId + '?title=' + encodeURIComponent(productTitle);
        });

        // Xử lý sự kiện thay đổi số lượng
        $('.input-number').on('change input', function() {
            var quantity = parseInt($(this).val());
            var cartId = $(this).closest('tr').find('.delete-cart-item').data('id');
            var productTitle = $(this).closest('tr').find('.delete-cart-item').data('title');

            if (quantity < 0) {
                // Hiển thị modal xác nhận xóa
                showDeleteConfirmModal(cartId, productTitle);
                // Đặt lại số lượng về 1 để tránh lỗi tạm thời
                $(this).val(1);
            }
        });

        // Hàm hiển thị modal xác nhận xóa
        function showDeleteConfirmModal(cartId, productTitle) {
            var deleteModal = `
                <div class="custom-modal" id="deleteModalCustom">
                    <div class="custom-modal-content">
                        <div class="custom-modal-header confirm-del">
                            <i class="fa fa-question-circle"></i>
                        </div>
                        <div class="custom-modal-body">
                            Bạn có chắc chắn muốn xóa <strong>${productTitle}</strong> khỏi giỏ hàng không?
                        </div>
                        <div class="custom-modal-footer confirms">
                            <form action="{{ url('cart/delete') }}/${cartId}" method="GET">
                                <button type="submit" class="modal-button success-button">Xóa</button>
                            </form>
                            <button class="modal-button error-button" onclick="$('#deleteModalCustom').fadeOut();">Hủy</button>
                        </div>
                    </div>
                </div>
            `;
            // Xóa modal cũ nếu tồn tại
            $('#deleteModalCustom').remove();
            $('body').append(deleteModal);
            $('#deleteModalCustom').fadeIn();
        }

    });
</script>
@endpush