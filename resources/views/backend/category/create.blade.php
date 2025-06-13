@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Thêm danh mục</h5>
    <div class="card-body">
      <form method="post" action="#">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Tóm tắt</label>
          <textarea class="form-control" id="summary" name="summary"></textarea>
          @error('summary')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="is_parent">Is Parent</label><br>
          <input type="checkbox" name='is_parent' id='is_parent' value='1' checked> Đúng                       
        </div>

        <div class="form-group d-none" id='parent_cat_div'>
          <label for="parent_id">Danh mục Parent</label>
          <select name="parent_id" class="form-control">
              <option>--Chọn bất kỳ danh mục nào--</option>
              @foreach($parent_cats as $key=>$parent_cat)
                  <option>{{$parent_cat->title}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Ảnh</label>
          <div class="input-group">
              <span class="input-group-btn" style="text-align: center; color: #fff; padding-right:4px">
                  <a class="btn btn-primary custom-button" href="{{ route('admin.under-development') }}">
                  <i class="fas fa-image"></i> Chọn
                  </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option>Hoạt động</option>
              <option>Không hoạt động</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn custom-button btn-dark">Cài lại</button>
          <a class="btn btn-success custom-button" href="{{ route('admin.under-development') }}">Lưu</a>
        </div>
      </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<style>
  /* Định dạng chung cho tất cả các nút */
  .custom-button {
    width: 100px; /* Kích thước cố định để các nút bằng nhau */
    padding: 8px 16px;
    font-size: 16px; /* Kích thước chữ thống nhất */
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
    background: #6AA8E8; /* Màu nhạt hơn khi hover */
  }

  /* Nút Cài lại (btn-warning) */
  .btn-warning.custom-button {
    background: #333333; /* Màu xám yêu cầu */
  }
  .btn-warning.custom-button:hover {
    background: #4d4d4d; /* Màu nhạt hơn khi hover */
  }

  /* Nút Lưu (btn-success) */
  .btn-success.custom-button {
    background: #28a745;
  }
  .btn-success.custom-button:hover {
    background: #34ce57; /* Màu nhạt hơn khi hover */
  }

  /* Xóa outline và thêm box-shadow khi focus/active */
  .custom-button:focus,
  .custom-button:active {
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2); /* Hiệu ứng focus nhẹ */
  }

</style>
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Viết mô tả ngắn.....",
        tabsize: 2,
        height: 120
      });
    });
</script>

<script>
  $('#is_parent').change(function(){
    var is_checked = $('#is_parent').prop('checked');
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush