@extends('layouts/admin')
@section('title','Create New Contactss')

@section('content_header')
<form action="{{ route('contacts.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Contacts </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          @if($aid=='')
            <a href="{{ url('contacts')}}" class="btn btn-light">« Kembali</a>                 
          @else
            <a href="{{ url('accounts')}}/view/{{$aid}}" class="btn btn-light">« Kembali</a>                 
          @endif             
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
            <h3 class="card-title"> Contacts Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contacts Owner</label>
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
                <label class="form-label col-3 col-form-label">Accounts</label>
                <div class="col">
                      <select class="form-select" name="accountid">
                        @if($aid==='')
                        <option selected value="0">-- Select --</option>
                        @endif
                        @foreach($Accounts as $account)
                          @if($account->id === $aid)
                            <option selected value="{{ $account->id }}">{{ $account->fullname}}</option>
                          @else
                            <option  value="{{ $account->id }}">{{ $account->fullname}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contacts Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="contactname" placeholder="Contacts Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="mobile" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">FAX</label>
                <div class="col">
                <input type="text" class="form-control" name="fax" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="aid" value="{{$aid}}">
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
                  <input type="text" class="form-control" name="optemail" aria-describedby="emailHelp" placeholder="" value="{{$contacts[0]->website}}">
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
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Address Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder=""></textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="province" aria-describedby="emailHelp" placeholder="Province">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billingaddress" placeholder=""></textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing  City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcity" placeholder="City Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingprovince" aria-describedby="emailHelp" placeholder="Province">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcountry" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingzipcode" aria-describedby="emailHelp" placeholder="">
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
        @if($aid=='')
          <a href="{{ url('contacts')}}" class="btn btn-light">« Kembali</a>                 
        @else
          <a href="{{ url('accounts')}}/view/{{$aid}}" class="btn btn-light">« Kembali</a>                 
        @endif
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