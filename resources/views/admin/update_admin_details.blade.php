@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">update Admin Details</h3>
            </div>
            <!-- /.card-header -->
          
      @if(Session::has('error_message'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top:10px;">
        {{ Session::get('error_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if(Session::has('success_message'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top:10px;">
        {{ Session::get('success_message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      @if ($errors->any())
      <div class="alert alert-danger" style="margin-top:10px;">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
            <!-- form start -->
            <form role="form" method="post" action="{{ url('/admin/update-admin-details') }}" name="updateAdminDetails" id="updateAdminDetails" enctype="multipart/form-data">
                @csrf
              <div class="card-body">
               <?php /* <div class="form-group">
                    <label for="exampleInputEmail1">Admin Name</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" name="admin_name" id="admin_name" placeholder="Enter Admin/Sub Admin Name">
                  </div> */?>
                <div class="form-group">
                  <label for="exampleInputEmail1">Admin Email</label>
                  <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Admin Type</label>
                    <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}" readonly="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" name="admin_name" id="admin_name" placeholder="Enter Admin Name">
                  </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Mobile No.</label>
                  <input type="text" class="form-control" name="admin_mobile" id="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="Enter admin mobile no" required>
                    <span id="chkCurrentPwd"></span>
                </div>
     
                <div class="form-group">
                    <label for="exampleInputPassword1">Image</label>
                    <input type="file" class="form-control" name="admin-image" id="admin_image" accept="image/*">
                    @if(!empty(Auth::guard('admin')->user()->image))
                    <a target="blank" href="{{ url('image/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">view image</a>
                     <input type="hidden" name="current-admin-image" value="{{ Auth::guard('admin')->user()->image }}">   
                    @endif
                  </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
    
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  </div>
  @endsection