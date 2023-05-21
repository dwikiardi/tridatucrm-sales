@extends('layouts/admin')
@section('title','Create New Servicess')

@section('content_header')
<form action="{{ route('products.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Services </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('products/view',$products[0]->id)}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Services Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="producttype" value="0">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Service Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="productname" placeholder="Service Name" required value="{{ $products[0]->productname}}">
                </div>
              </div>
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Description</label>
                <div class="col">
                <textarea class="form-control" name="description" placeholder="">{{$products->description}}</textarea>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{$products->note}}</textarea>
                </div>
              </div>
               
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
      <a href="{{ url('products')}}" class="btn btn-light">« Kembali</a>                 
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