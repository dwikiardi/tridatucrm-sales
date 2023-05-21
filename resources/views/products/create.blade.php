@extends('layouts/admin')
@section('title','Create New Products')

@section('content_header')
<form action="{{ route('products.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Product </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('products')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Product Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="producttype" value="1">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Product Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="productname" placeholder="Product Name" required>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Have Serial Numbers</label>
                    <span class="col-auto">
                      <label class="form-check form-check-single form-switch">
                        <input class="form-check-input" type="checkbox" checked="" name="havesn" value="1">
                      </label>
                    </span>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Description</label>
                <div class="col">
                <textarea class="form-control" name="description" placeholder=""></textarea>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder=""></textarea>
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