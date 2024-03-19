@extends('layouts/admin')
@section('title','Create New Staff')

@section('content_header')
<form action="{{ route('staff.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Staff </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('staff')}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
@stop
@section('content')

@csrf
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Staff Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-12">
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">User Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="username" placeholder="User Name" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Password</label>
                <div class="col">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Confirm Password</label>
                <div class="col">
                  <input type="password" class="form-control" name="confirmpass" placeholder="Confirm Password" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">First Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Last Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Role</label>
                <div class="col">
                      <select class="form-select" name="roleid">
                        @foreach($roles as $role)
                            <option  value="{{ $role->id }}">{{ $role->rolename}}</option>
                        @endforeach
                      </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Department</label>
                <div class="col">
                      <select class="form-select" name="departmentid">
                        @foreach($departments as $department)
                            <option  value="{{ $department->id }}">{{ $department->departement_name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>    

              
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            
          </div>
        </div>
      </div>
   
  </div> <!-- END Container-XL -->
</div>
  
<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <!-- Page pre-title -->
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none"> 
      <a href="{{ url('staff')}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')

<script type="text/javascript">
  $(function () {
      
   
      
  });
</script>
@endpush