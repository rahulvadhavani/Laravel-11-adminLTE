@extends('admin.layouts.app')
@push('style')
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
@endpush
@section('content')
@include('admin.components.breadcrumb')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All user lists</h3>
            <div class="text-right">
              <button class="btn btn-sm btn-dark float-right  ml-2" onclick="addModel()"><i class="fa fa-plus" aria-hidden="true"></i> Add User</button>
              <button id="delete_selected" class="btn btn-sm btn-danger float-right" disabled>Delete Selected</button>
            </div>
          </div>
          <form id="form_delete_selected" method="post">
            @csrf
            <div class="card-body">
              <table id="data_table_main" class="table table-bordered table-striped w-100">
                <thead>
                  <tr>
                    <th class="text-center"><input type="checkbox" name="select_all" value="1" id="delete-select-checkbox"></th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </form>
          <input type="hidden" id="delete_selected_url" value="{{route('admin.users.delete-selected')}}">
          <input type="hidden" id="moduke_index_url" value="{{route('admin.users.index')}}">
        </div>
      </div>
    </div>
  </div>
</section>
@include('admin.users.modal')
@endsection
@push('script')
<script src="{{asset('assets/js/custom/users.js')}}"></script>
@endpush