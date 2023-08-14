@extends('layouts/admin')
@section('title','Update Product')

@section('content_header')
<form action="{{ route('product.update') }}" method="POST">    
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
          <a href="{{ url('product/view',$stocks[0])}}" class="btn btn-light">« Kembali</a>   
                        
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
@stop
@section('content')

@csrf
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
    <div class="col-md-6">
      <div class="card">
        <div class="card-header bg-blue-lt">
          <h3 class="card-title"> Product Information</h3>
        </div>
        <div class="card-body row">
          <div class="col-12">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Product Code</label>
              <div class="col">
                <input type="text" class="form-control" name="stockid" placeholder="Product Code" disabled value="{{$stocks[0]->stockid}}">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Product Name</label>
              <div class="col">
                <input type="text" class="form-control" name="stockname" placeholder="Product Name" required value="{{$stocks[0]->stockname}}">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Description</label>
              <div class="col">
              <textarea class="form-control" name="desk" placeholder="">{{$stocks[0]->desk}}</textarea>
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Product Category</label>
              <div class="col">
                    <select class="form-select" name="categoryid">
                      @foreach($categorys as $category)
                        @if($category->id==$stocks[0]->categoryid)
                          <option selected value="{{ $category->id }}">{{ $category->category_name}}</option>
                        @else
                          <option  value="{{ $category->id }}">{{ $category->category_name}}</option>
                        @endif
                          
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Unit Type </label>
              <div class="col">
                <input type="text" class="form-control" name="unit" placeholder="Unit Type" value="{{$stocks[0]->unit}}">
                <span style="font-size:10px;">ex: Pcs/Unit/Meters/Kg/Gram</span>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Product Qty Type</label>
              <div class="col">
                    <select class="form-select" name="qtytype" disabled>
                      <option 
                      @if($stocks[0]->qtytype == 0)
                        selected
                      @endif
                      value="0">Qty</option>
                      <option 
                      @if($stocks[0]->qtytype == 1)
                        selected
                      @endif
                      value="1">By Summary of Serial Number</option>
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Sell Price</label>
              <div class="col">
                <input type="number" class="form-control" name="sell_price" placeholder="Sell Price" value="{{$stocks[0]->sell_price}}">
              </div>
            </div>
            <input type="hidden" name="id"  value="{{$stocks[0]->id}}">
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
        <a href="{{ url('product/view',$stocks[0])}}" class="btn btn-light">« Kembali</a>            
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