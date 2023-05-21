@extends('layouts/admin')
@section('title','Update Contacts')

@section('content_header')
<form action="{{ route('contacts.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Contact </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('contacts/view',$contacts[0]->id)}}" class="btn btn-light">« Kembali</a>
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
            <h3 class="card-title"> Contact Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
            <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid">
                        @foreach($Users as $user)
                          @if($user->id=== $contacts[0]->ownerid)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                     
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Account</label>
                <div class="col">
                      <select class="form-select" name="accountid">
                        @foreach($accounts as $account)
                          @if($account->id=== $contacts[0]->accountid)
                            <option selected value="{{ $account->id }}">{{ $account->fullname}}</option>
                          @else
                            <option  value="{{ $account->id }}">{{ $account->fullname}} </option>
                          @endif
                        @endforeach
                      </select>
                      
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="contactname" placeholder="Contact Name" value="{{$contacts[0]->contactname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" value="{{$contacts[0]->email}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="mobile" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->phone}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->phone}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">FAX</label>
                <div class="col">
                <input type="text" class="form-control" name="fax" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->fax}}">
                </div>
              </div>  
              <input type="hidden" name="id" value="{{$contacts[0]->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Other Email(Option)</label>
                <div class="col">
                  <input type="email" class="form-control" name="optemail" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->website}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Other Mobile(Option)</label>
                <div class="col">
                  <input type="text" class="form-control" name="optmobile" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->website}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{$contacts[0]->note}}</textarea>
                </div>
              </div>  
               
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Contact Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder="">{{$contacts[0]->address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City Name" value="{{$contacts[0]->city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="province" aria-describedby="emailHelp" placeholder="Province" value="{{$contacts[0]->province}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->zipcode}}">
                </div>
              </div>  
              
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billingaddress" placeholder="">{{$contacts[0]->billingaddress}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing  City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcity" placeholder="City Name"value="{{$contacts[0]->billingcity}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingprovince" aria-describedby="emailHelp" placeholder="Province" value="{{$contacts[0]->province}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcountry" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingzipcode" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->billingzipcode}}">
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
      <a href="{{ url('contacts/view',$contacts[0]->id)}}" class="btn btn-light">« Kembali</a>            
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