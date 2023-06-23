@extends('layouts/admin')
@section('title','Update Service')

@section('content_header')
<form action="{{ route('services.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Service </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('services/view',$services[0])}}" class="btn btn-light">« Kembali</a>   
                        
          <button type="submit" class="btn btn-primary">Update</button>
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
          <h3 class="card-title"> Service Information</h3>
        </div>
        <div class="card-body row">
          <div class="col-md-6">
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Services Name</label>
              <div class="col">
                <input type="text" class="form-control" name="services_name" placeholder="Services Name" required value="{{$services[0]->services_name}}">
              </div>
            </div>
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Description</label>
              <div class="col">
              <textarea class="form-control" name="desk" placeholder="">{{$services[0]->desk}}</textarea>
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Price</label>
              <div class="col">
                <input type="number" class="form-control" name="price" placeholder="Service Price" value="{{$services[0]->price}}">
              </div>
            </div>

            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Note</label>
              <div class="col">
              <textarea class="form-control" name="note" placeholder="">{{$services[0]->note}}</textarea>
              </div>
            </div>
            
            <input type="hidden" name="id" value="{{$services[0]->id}}">
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
        <a href="{{ url('services/view',$services[0])}}" class="btn btn-light">« Kembali</a>            
        <button type="submit" class="btn btn-primary">Update</button>
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