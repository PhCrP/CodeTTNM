@extends('backend.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="row">
    <div class="col-md-12">
      @include('backend.layouts.notification')
      <!-- Modal xác nhận xóa -->
      <div class="custom-modal" id="confirmDeleteModal" style="display: none;">
        <div class="custom-modal-content">
          <div class="custom-modal-header confirm-del">
            <span class="modal-title-text">Xác nhận xóa</span>
            <i class="fa fa-question-circle"></i>
            <span class="close-modal" onclick="$('#confirmDeleteModal').fadeOut();">×</span>
          </div>
          <div class="custom-modal-body">
            <h5>Bạn có chắc không?</h5>
            <p>Bạn sẽ không thể khôi phục lại dữ liệu này!</p>
          </div>
          <div class="custom-modal-footer">
            <button class="modal-button cancel-button" onclick="$('#confirmDeleteModal').fadeOut();">Hủy</button>
            <button class="modal-button error-button" id="confirmDeleteButton">Xóa</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">Danh sách sản phẩm</h6>
    <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if(count($products)>0)
      <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>STT</th>
            <th>Tiêu đề</th>
            <th>Danh mục</th>
            <th>Is Featured</th>
            <th>Giá</th>
            <th>Giảm giá</th>
            <th>Kích thước</th>
            <th>Điều kiện</th>
            <th>Thương hiệu</th>
            <th>Kho</th>
            <th>Ảnh</th>
            <th>Trạng thái</th>
            <th>Hoạt động</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>STT</th>
            <th>Tiêu đề</th>
            <th>Danh mục</th>
            <th>Is Featured</th>
            <th>Giá</th>
            <th>Giảm giá</th>
            <th>Kích thước</th>
            <th>Điều kiện</th>
            <th>Thương hiệu</th>
            <th>Kho</th>
            <th>Ảnh</th>
            <th>Trạng thái</th>
            <th>Hoạt động</th>
          </tr>
        </tfoot>
        <tbody>
          @foreach($products as $index => $product)
          @php
          $sub_cat_info = DB::table('categories')->select('title')->where('id', $product->child_cat_id)->get();
          $brands = DB::table('brands')->select('title')->where('id', $product->brand_id)->get();
          @endphp
          <tr>
            <td>{{ $index + 1 }}</td> <!-- Display sequential number starting from 1 -->
            <td>{{ $product->title }}</td>
            <td>
              {{ $product->cat_info['title'] }}
              <sub>{{ $product->sub_cat_info->title ?? '' }}</sub>
            </td>
            <td>{{ $product->is_featured == 1 ? 'Yes' : 'No' }}</td>
            <td>{{ $product->price }} VNĐ</td>
            <td>{{ $product->discount }}% OFF</td>
            <td>{{ $product->size }}</td>
            <td>{{ $product->condition }}</td>
            <td>{{ ucfirst($product->brand->title) }}</td>
            <td>
              @if($product->stock > 0)
              <span class="badge badge-primary">{{ $product->stock }}</span>
              @else
              <span class="badge badge-danger">{{ $product->stock }}</span>
              @endif
            </td>
            <td>
              @if($product->photo)
              @php
              $photo = explode(',', $product->photo);
              @endphp
              <img src="{{ $photo[0] }}" class="img-fluid zoom" style="max-width:80px" alt="{{ $product->photo }}">
              @else
              <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid" style="max-width:80px" alt="avatar.png">
              @endif
            </td>
            <td>
              @if($product->status == 'active')
              <span class="badge badge-success">{{ $product->status }}</span>
              @else
              <span class="badge badge-warning">{{ $product->status }}</span>
              @endif
            </td>
            <td>
              <div class="h-100 d-flex justify-content-center align-items-center">
                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm float-left mr-2" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="{{ route('product.destroy', [$product->id]) }}">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger btn-sm dltBtn" data-id="{{ $product->id }}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="pagination-info">
          Hiển thị từ {{ $products->firstItem() }} đến {{ $products->lastItem() }} của {{ $products->total() }} bản ghi
        </span>
        <span class="pagination-links ms-auto">
          @if ($products->hasPages())
          {{ $products->links() }}
          @else
          <ul class="pagination">
            <li class="page-item disabled">
              <span class="page-link"><i class="fas fa-angle-left"></i></span>
            </li>
            <li class="page-item active">
              <span class="page-link">1</span>
            </li>
            <li class="page-item disabled">
              <span class="page-link"><i class="fas fa-angle-right"></i></span>
            </li>
          </ul>
          @endif
        </span>
      </div>
      @else
      <h6 class="text-center">Không tìm thấy sản phẩm nào!!! Vui lòng tạo sản phẩm</h6>
      @endif
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
  div.dataTables_wrapper div.dataTables_paginate {
    display: none;
  }

  .zoom {
    transition: transform .2s;
    border-radius: 4px;
    /* Animation */
  }

  .zoom:hover {
    transform: scale(2);
    border-radius: 4px;
  }

  .custom-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #333333;
    z-index: 1000;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .custom-modal-content {
    background: #F5F6F5;
    width: 90%;
    max-width: 400px;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    overflow: hidden;
  }

  .custom-modal-header {
    padding: 25px 0 10px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #F5F6F5;
  }

  .custom-modal-header.error {
    background: transparent;
  }

  .custom-modal-header.error i {
    color: #D32F2F;
    font-size: 90px;
  }

  .custom-modal-header.confirm-del i {
    color: #ffc107;
  }

  .custom-modal-body {
    padding: 10px 0;
    text-align: center;
    font-size: 16px;
    color: #333333;
  }

  .custom-modal-footer {
    padding: 10px 0 15px;
    text-align: center;
    border-top: 1px solid #e0e0e0;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
  }

  .modal-button {
    padding: 8px 16px;
    width: 100px;
    color: #F5F6F5;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
  }

  .error-button {
    background: #D32F2F;
  }

  .error-button:hover {
    background: #B71C1C;
  }

  .cancel-button {
    background: #333333;
  }

  .cancel-button:hover {
    background: rgb(72, 72, 72);
  }

  #product-dataTable th,
  #product-dataTable td {

    text-align: center;
    vertical-align: middle;
  }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
  $('#product-dataTable').DataTable({
    "scrollX": false,
    "columnDefs": [{
      "targets": [10, 11, 12]
    }],
    "lengthChange": false,
    "language": {
      "search": "Tìm kiếm:",
      "emptyTable": "Không có dữ liệu trong bảng",
      "zeroRecords": "Không tìm thấy thông tin phù hợp",
    },
    "info": false,
  });

  // Sweet alert

  function deleteData(id) {

  }
</script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.dltBtn').click(function(e) {
      e.preventDefault();
      var form = $(this).closest('form');
      $('#confirmDeleteModal').fadeIn();
      $('#confirmDeleteButton').off('click').on('click', function() {
        form.submit();
      });
    });
  });
</script>
@endpush