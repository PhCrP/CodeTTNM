@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Thêm người dùng</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tên <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Nhập tên"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input id="inputEmail" type="email" name="email" placeholder="Nhập email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
          <input id="inputPassword" type="password" name="password" placeholder="Nhập mật khẩu"  value="{{old('password')}}" class="form-control">
          @error('password')
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
        <img id="holder" style="margin-top:15px;max-height:100px;">
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @php 
        $roles=DB::table('users')->select('role')->get();
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Vai trò <span class="text-danger">*</span></label>
            <select name="role" class="form-control">
                <option value="">-----Chọn vai trò-----</option>
                @foreach($roles as $role)
                    <option value="{{$role->role}}">{{$role->role}}</option>
                @endforeach
            </select>
          @error('role')
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
<script>
    $('#lfm').filemanager('image');
</script>
@endpush