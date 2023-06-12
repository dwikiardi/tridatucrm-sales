@extends('layouts/admin')
@section('title','Create New Productss')

@section('content_header')
<form action="{{ route('products.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Products </h1>
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
            <h3 class="card-title"> Products Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
                  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Products Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="productname" placeholder="Products Name" required value="{{$products[0]->productname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Have Serial Numbers</label>
                    <span class="col-auto">
                      <label class="form-check form-check-single form-switch">
                        <input class="form-check-input" type="checkbox"  name="havesn" value="1"
                        @if($products[0]->havesn == 1)
                          checked
                        @endif
                        >
                      </label>
                    </span>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Description</label>
                <div class="col">
                <textarea class="form-control" name="description" placeholder="">{{ $products[0]->description}}</textarea>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Price</label>
                <div class="col">
                  <input type="number" class="form-control" name="price" placeholder="Price" value="{{$products[0]->price}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{ $products[0]->note}}</textarea>
                </div>
              </div>
              
              <input type="hidden" name="id"  value="{{$products[0]->id}}">
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