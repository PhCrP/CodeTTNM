@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
  @include('user.layouts.notification')
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển</h1>
  </div>

  <!-- Content Row -->
  {{-- <div class="row">

      <!-- Category -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Danh mục</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Category::countActiveCategory()}}
</div>
</div>
<div class="col-auto">
  <i class="fas fa-sitemap fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

<!-- Products -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sản phẩm</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Product::countActiveProduct()}}</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-cubes fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Posts-->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Post</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Post::countActivePost()}}</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-folder fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
</div>
</div> --}}

<!-- Content Row -->


</div>
@endsection
