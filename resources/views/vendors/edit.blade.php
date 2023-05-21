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
                <label class="form-label col-3 col-form-label">Vendor Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid">
                        @foreach($Users as $user)
                          @if($user->id=== Auth::user()->id)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Vendor Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="vendorname" placeholder="Vendor Name" required value="{{$vendors[0]->vendorname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Vendor Type</label>
                <div class="col">
                      <select class="form-select" name="vendortype">
                          <option value="1">Vendor Jasa</option>
                          <option value="2">Vendor Barang</option>
                          <option value="3">Vendor Lain</option>
                      </select>
                </div>
              </div> 
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder=""> {{$vendors[0]->address}}</textarea>
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
                  <input type="text" class="form-control" name="province" aria-describedby="emailHelp" placeholder="Province" value="{{$vendors[0]->province}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->country}}">
                </div>
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="contactname" aria-describedby="emailHelp" placeholder="" required  value="{{$vendors[0]->contactname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="mobile" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->mobile}}">
                </div>
              </div> 
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" value="{{$vendors[0]->email}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Website</label>
                <div class="col">
                  <input type="text" class="form-control" name="website" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->website}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="" value="{{$vendors[0]->phone}}">
                </div>
              </div>  
              
              <input type="hidden" name="id"  value="{{$vendors[0]->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder=""> {{$vendors[0]->note}}</textarea>
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