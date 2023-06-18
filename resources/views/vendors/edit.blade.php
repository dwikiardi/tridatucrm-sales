@extends('layouts/admin')
@section('title','Create New Vendors')

@section('content_header')
<form action="{{ route('vendors.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Vendor </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('vendors/view',$vendors[0])}}" class="btn btn-light">« Kembali</a>   
                        
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
            <h3 class="card-title"> Vendor Information</h3>
          </div>
          <div class="card-body row">
          <div class="col-md-6">
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Vendor Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="vendor_name" placeholder="Vendor Name" required value="{{$vendors[0]->vendor_name}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Vendor Type</label>
                <div class="col">
                      <select class="form-select" name="type">
                          <option 
                          @if($vendors[0]->type==1)
                            selected
                          @endif 
                          value="1">Vendor Jasa</option>
                          <option  
                          @if($vendors[0]->type==2)
                            selected
                          @endif 
                          value="2">Vendor Barang</option>
                          <option  
                          @if($vendors[0]->type==31)
                            selected
                          @endif 
                          value="3">Vendor Lain</option>
                      </select>
                </div>
              </div> 
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="contact" placeholder="Contact Name" value="{{$vendors[0]->contact}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Email</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" placeholder="Contact Email" value="{{$vendors[0]->email}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="mobile" placeholder="Contact Mobile" value="{{$vendors[0]->mobile}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" placeholder="Contact Phone" value="{{$vendors[0]->phone}}">
                </div>
              </div>
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder="">{{$vendors[0]->address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City Name" value="{{$vendors[0]->city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="state" aria-describedby="emailHelp" placeholder="Province" value="{{$vendors[0]->state}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->country}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->zipcode}}">
                </div>
              </div>

              <input type="hidden" name="id" value="{{$vendors[0]->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_contact" placeholder="Billing Name" required value="{{$vendors[0]->billing_contact}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Email</label>
                <div class="col">
                  <input type="email" class="form-control" name="billing_email" placeholder="Billing Email" value="{{$vendors[0]->billing_email}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_mobile" placeholder="Billing Mobile" value="{{$vendors[0]->billing_mobile}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_phone" placeholder="Billing Phone" value="{{$vendors[0]->billing_phone}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billing_address" placeholder="">{{$vendors[0]->billing_address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_city" placeholder="City Name" value="{{$vendors[0]->billing_city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_state" aria-describedby="emailHelp" placeholder="Province" value="{{$vendors[0]->billing_state}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_country" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->billing_country}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_zipcode" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->billing_zipcode}}">
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
        <a href="{{ url('vendors/view',$vendors[0])}}" class="btn btn-light">« Kembali</a>            
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