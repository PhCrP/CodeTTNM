@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Cập nhật người dùng</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Tên <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Nhập tên"  value="{{$user->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input id="inputEmail" type="email" name="email" placeholder="Nhập email"  value="{{$user->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Mật khẩu <span class="text-danger">*</span></label>
          <input id="inputPassword" type="password" name="password" placeholder="Nhập mật khẩu"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-btn" style="text-align: center; color: #fff; padding-right:4px">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary custom-button">
                  <i class="fas fa-image"></i> Chọn
                  </a>
            </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$user->photo}}">
        </div>
        <img id="holder" style="margin-top:15px;max-height:100px;">
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        @php 
        $roles=DB::table('users')->select('role')->where('id',$user->id)->get();
        // dd($roles);
        @endphp
        <div class="form-group">
            <label for="role" class="col-form-label">Vai trò <span class="text-danger">*</span></label>
            <select name="role" class="form-control">
                <option value="">-----Chọn vai trò-----</option>
                @foreach($roles as $role)
                    <option value="{{$role->role}}" {{(($role->role=='admin') ? 'selected' : '')}}>Quản trị viên</option>
                    <option value="{{$role->role}}" {{(($role->role=='user') ? 'selected' : '')}}>Người dùng</option>
                @endforeach
            </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{(($user->status=='active') ? 'selected' : '')}}>Hoạt động</option>
                <option value="inactive" {{(($user->status=='inactive') ? 'selected' : '')}}>Không hoạt động</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
           <button class="btn btn-success custom-button" type="submit">Cập nhật</button>
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
    text-align: center;
    font-weight: bold;
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

  /* Đảm bảo không có outline trên các trạng thái khác */
  .btn-primary.custom-button:focus,
  .btn-success.custom-button:focus {
    outline: none !important;
  }
</style>
@endpush

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush