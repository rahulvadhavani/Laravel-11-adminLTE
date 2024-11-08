@extends('admin.layouts.app')
@section('content')
@include('admin.components.breadcrumb')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <label id="profile_img">
                <div id="preview_div">
                  <img id="image_preview" class="image_preview profile-user-img img-fluid img-circle admin_profile" height=150 width=150 src="{{$user->image}}">
                </div>
              </label>
            </div>
            <h3 class="profile-username text-center">{{$user->email??'-'}}</h3>
            <ul class="nav nav-pills d-block">
              <li class="nav-item my-1"><a class="border rounded nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
              <li class="nav-item my-1"><a class="border rounded nav-link" href="#password" data-toggle="tab">Password</a></li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          {{-- <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Password</a></li>
            </ul>
          </div> --}}
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="profile">
                <form id="profile_frm" form_name="profile_frm" method="post" action="{{ route('admin.update_profile') }}">
                  <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Firstname <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="Please enter firstname" id="first_name" name="first_name" value="{{$user->first_name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Lastname <span class="red">*</span></label>
                          <input type="text" class="form-control" placeholder="Please enter lastname" id="last_name" name="last_name" value="{{$user->last_name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Username <span class="red">*</span></label>
                          <input type="text" class="form-control" onkeypress="return Validateusername(event)" placeholder="Please enter username" id="username" name="name" value="{{$user->name}}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Email <span class="red">*</span></label>
                          <input type="read" class="form-control" placeholder="Please enter email" value="{{$user->email}}" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label>Image</label>
                          <input type="file" name="image" id="image" class="form-control" style="padding: 0.200rem 0.75rem;" placeholder="Enter Select Image" onchange="load_preview_image(this);" accept="image/x-png,image/jpg,image/jpeg">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-indigo btn-flat float-right" id="profile_frm_btn">Update Profile <span style="display: none" id="profile_frm_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="password">
                <form id="password_frm" form_name="password_frm" method="post" action="{{ route('admin.update_password') }}">
                  <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Old Password</label>
                          <input type="password" class="form-control" placeholder="Please enter old password" id="old_password" name="old_password">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" placeholder="Please enter password" id="password" name="password">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Confirm Password</label>
                          <input type="password" class="form-control" placeholder="Please enter confirm password" id="password_confirmation" name="password_confirmation">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-indigo btn-flat float-right" id="password_frm_btn">Update Password <span style="display: none" id="password_frm_loader"><i class="fa fa-spinner fa-spin"></i></span></button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection
@push('script')
<script src="{{asset('assets/js/custom/profile.js')}}"></script>
@endpush