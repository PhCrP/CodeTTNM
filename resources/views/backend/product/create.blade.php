@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Thêm sản phẩm</h5>
  <div class="card-body">
    <form method="post" action="{{route('product.store')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
        <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
        @error('summary')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description" class="col-form-label">Miêu tả</label>
        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>


      <div class="form-group">
        <label for="is_featured">Is Featured</label><br>
        <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Đúng
      </div>
      {{-- {{$categories}} --}}

      <div class="form-group">
        <label for="cat_id">Danh mục <span class="text-danger">*</span></label>
        <select name="cat_id" id="cat_id" class="form-control">
          <option value="">Tùy chọn danh mục</option>
          @foreach($categories as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group d-none" id="child_cat_div">
        <label for="child_cat_id">Danh mục phụ</label>
        <select name="child_cat_id" id="child_cat_id" class="form-control">
          <option value="">--Chọn bất kỳ danh mục--</option>
          {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
          @endforeach --}}
        </select>
      </div>

      <div class="form-group">
        <label for="price" class="col-form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{old('price')}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="discount" class="col-form-label">Giảm giá(%)</label>
        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Nhập mã giảm giá" value="{{old('discount')}}" class="form-control">
        @error('discount')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="size">Kích thước</label>
        <select name="size[]" class="form-control selectpicker" multiple data-live-search="true" data-none-selected-text="Chọn bất kỳ kích thước">
          <option class="text-dark" value="128GB">128GB</option>
          <option class="text-dark" value="256GB">256GB</option>
          <option class="text-dark" value="512GB">512GB</option>
          <option class="text-dark" value="1TB">1TB</option>
        </select>
      </div>

      <div class="form-group">
        <label for="brand_id">Thương hiệu</label>
        {{-- {{$brands}} --}}

        <select name="brand_id" class="form-control">
          <option value="">Chọn thương hiệu</option>
          @foreach($brands as $brand)
          <option value="{{$brand->id}}">{{$brand->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="condition">Điều kiện</label>
        <select name="condition" class="form-control">
          <option value="">Chọn điều kiện</option>
          <option value="default">Mặc định</option>
          <option value="new">Mới</option>
          <option value="hot">Hot</option>
        </select>
      </div>

      <div class="form-group">
        <label for="stock">Số lượng <span class="text-danger">*</span></label>
        <input id="quantity" type="number" name="stock" min="0" placeholder="Nhập số lượng" value="{{old('stock')}}" class="form-control">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-btn" style="text-align: center; color: #fff; padding-right:4px">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary custom-button">
              <i class="fas fa-image"></i> Chọn
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        @error('photo')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status" class="col-form-label">Trạng thái</label>
        <select name="status" class="form-control">
          <option value="active">Hoạt động</option>
          <option value="inactive">Không hoạt động</option>
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group mb-3">
        <button type="reset" class="btn custom-button btn-dark">Cài lại</button>
        <button class="btn btn-success custom-button" type="submit">Lưu</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
  /* Định dạng chung cho tất cả các nút */
  .custom-button {
    width: 100px;
    /* Kích thước cố định để các nút bằng nhau */
    padding: 8px 16px;
    font-size: 16px;
    /* Kích thước chữ thống nhất */
    font-weight: bold;
    text-align: center;
    border-radius: 4px;
    color: #fff;
    border: none;
    cursor: pointer;
  }

  /* Nút Chọn (btn-primary) */
  .btn-primary.custom-button {
    background: #4A90E2;
  }

  .btn-primary.custom-button:hover {
    background: #6AA8E8;
    /* Màu nhạt hơn khi hover */
  }

  /* Nút Cài lại (btn-warning) */
  .btn-warning.custom-button {
    background: #333333;
    /* Màu xám yêu cầu */
  }

  .btn-warning.custom-button:hover {
    background: #4d4d4d;
    /* Màu nhạt hơn khi hover */
  }

  /* Nút Lưu (btn-success) */
  .btn-success.custom-button {
    background: #28a745;
  }

  .btn-success.custom-button:hover {
    background: #34ce57;
    /* Màu nhạt hơn khi hover */
  }

  /* Xóa outline và thêm box-shadow khi focus/active */
  .custom-button:focus,
  .custom-button:active {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
    /* Hiệu ứng focus nhẹ */
  }
</style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#lfm').filemanager('image');

  $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Viết mô tả ngắn.....",
      tabsize: 2,
      height: 100
    });
  });

  $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Viết mô tả chi tiết.....",
      tabsize: 2,
      height: 150
    });
  });
  // $('select').selectpicker();
</script>

<script>
  $('#cat_id').change(function() {
    var cat_id = $(this).val();
    // alert(cat_id);
    if (cat_id != null) {
      // Ajax call
      $.ajax({
        url: "/admin/category/" + cat_id + "/child",
        data: {
          _token: "{{csrf_token()}}",
          id: cat_id
        },
        type: "POST",
        success: function(response) {
          if (typeof(response) != 'object') {
            response = $.parseJSON(response)
          }
          // console.log(response);
          var html_option = "<option value=''>----Chọn danh mục phụ----</option>"
          if (response.status) {
            var data = response.data;
            // alert(data);
            if (response.data) {
              $('#child_cat_div').removeClass('d-none');
              $.each(data, function(id, title) {
                html_option += "<option value='" + id + "'>" + title + "</option>"
              });
            } else {}
          } else {
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    } else {}
  })
</script>
@endpush