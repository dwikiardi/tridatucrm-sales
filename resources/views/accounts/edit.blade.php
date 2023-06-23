@extends('layouts/admin')
@section('title','Create New Accounts')

@section('content_header')
<form action="{{ route('accounts.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Account </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('accounts/view',$accounts[0]->id)}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Account Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Account Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid">
                        @foreach($Users as $user)
                          @if($user->id=== $accounts[0]->ownerid)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Account Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="account_name" placeholder="Account Name" value="{{$accounts[0]->account_name}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder="">{{$accounts[0]->address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City Name" value="{{$accounts[0]->city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="state" aria-describedby="emailHelp" placeholder="Province" value="{{$accounts[0]->state}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->zipcode}}">
                </div>
              </div>  
              <!-- <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">FAX</label>
                <div class="col">
                <input type="text" class="form-control" name="fax" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->fax}}">
                </div>
              </div>   -->
              <input type="hidden" name="id" value="{{$accounts[0]->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" value="{{$accounts[0]->email}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Website</label>
                <div class="col">
                  <input type="text" class="form-control" name="website" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->website}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->phone}}">
                </div>
              </div>  
              <!-- <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Account Type</label>
                <div class="col">
                      <select class="form-select" name="accounttype">
                          <option value="1">Potensial Customer</option>
                          <option value="2">Active Customer</option>
                          <option value="3">InActive Customer</option>
                      </select>
                </div>
              </div>  -->
              
              <!-- <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{$accounts[0]->note}}</textarea>
                </div>
              </div>   -->
               
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
        <a href="{{ url('accounts/view',$accounts[0]->id)}}" class="btn btn-light">« Kembali</a>                    
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