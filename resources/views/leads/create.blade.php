@extends('layouts/admin')
@section('title','Create New Leads')

@section('content_header')
<form action="{{ route('leads.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Lead </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('leads')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Company's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead Owner</label>
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
                <label class="form-label col-3 col-form-label">Lead Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="leadsname" placeholder="Lead Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Company Name</label>
                <div class="col">
                  <input type="text" class="form-control company" name="account_name" placeholder="Company Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder=""></textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="state" aria-describedby="emailHelp" placeholder="Province">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="Country">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="ZIP Code">
                </div>
              </div>
              
              <input type="hidden" name="accountid" id="accountid" value="">
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Website</label>
                <div class="col">
                  <input type="text" class="form-control" name="website" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billing_address" placeholder=""></textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_city" placeholder="City Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_state" aria-describedby="emailHelp" placeholder="Province">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_country" aria-describedby="emailHelp" placeholder="">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_zipcode" aria-describedby="emailHelp" placeholder="">
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
                <label class="form-label col-3 col-form-label">PIC Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="pic_contact" placeholder="PIC Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC E-Mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="pic_email" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="pic_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="pic_phone" aria-describedby="emailHelp" placeholder="Phone Number">
                </div>
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_contact" placeholder="PIC Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing E-Mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="billing_email" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_phone" aria-describedby="emailHelp" placeholder="Phone Number">
                </div>
              </div>
               
              
            </div>
          </div>
          
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Other Information </h3>
          </div>
          <div class="card-body row" >
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Latitude</label>
                <div class="col">
                <input type="text" class="form-control" name="maplat" aria-describedby="emailHelp" placeholder="MAP Latitude">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Longitude</label>
                <div class="col">
                <input type="text" class="form-control" name="maplong" aria-describedby="emailHelp" placeholder="MAP Longitude">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Google Map URL</label>
                <div class="col">
                <input type="text" class="form-control" name="gmapurl" aria-describedby="emailHelp" placeholder=">Google Map URL">
                </div>
              </div>
            </div> 
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead Status</label>
                <div class="col">
                  <select class="form-select" name="status">
                    <option value="New Contact">New Contact</option>
                    <option value="Future Contact">Future Contact</option>
                    <option value="Tobe Contacted">Tobe Contacted</option>
                    <option value="Contacted">Contacted</option>
                    <option value="Waiting for Response">Waiting for Response</option>
                    <option value="Cannot be Contacted">Cannot be Contacted</option>
                  </select>
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
      <a href="{{ url('leads')}}" class="btn btn-light">« Kembali</a>                 
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