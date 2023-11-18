@extends('layouts/admin')
@section('title','Create New Contact')

@section('content_header')
<form action="{{ route('leads.cstore') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Contact </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('contacts')}}" class="btn btn-light">« Kembali</a>                 
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
          <h3 class="card-title"> Account's Information</h3>
        </div>
        <div class="card-body row">
          <div class="col-md-6">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Contact Owner</label>
              <div class="col">
                    <select class="form-select" name="ownerid">
                    
                      @foreach($Users as $user)
                        @if($user->id===  $id)
                          <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @else
                          <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                        @endif
                      @endforeach
                    </select>
              </div>
            </div>    
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Contact Name</label>
              <div class="col">
                <input type="text" class="form-control" name="leadsname" placeholder="Contacts Name" value="" required>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Account Name</label>
              <div class="col">
                    <select class="form-select accountid" name="accountid">
                    @if($id)
                    @else
                    <option selected value="">-- Select one --</option>
                    @endif
                    
                      @foreach($Accounts as $account)
                        @if($account->id ==  $id)
                          <option selected value="{{ $account->id }}" data-dtl="{{ $account->address}}|{{ $account->city}}|{{ $account->state}}|{{ $account->country}}|{{ $account->zipcode}}|{{ $account->email}}|{{ $account->website}}|{{ $account->phone}}">{{ $account->account_name}}</option>
                        @else
                          <option  value="{{ $account->id }}" data-dtl="{{ $account->address}}|{{ $account->city}}|{{ $account->state}}|{{ $account->country}}|{{ $account->zipcode}}|{{ $account->email}}|{{ $account->website}}|{{ $account->phone}}">{{ $account->account_name}}</option>
                        @endif
                      @endforeach
                    </select>
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Address</label>
              <div class="col">
              <textarea readonly class="form-control address" name="address" placeholder="">@if($acc!=''){{ $acc[0]->address }}@endif</textarea>
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">City</label>
              <div class="col">
                <input readonly type="text" class="form-control city" name="city" placeholder="City"  value="@if($acc!=''){{ $acc[0]->city }}@endif">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">State/Province</label>
              <div class="col">
                <input readonly type="text" class="form-control state" name="state" aria-describedby="emailHelp" placeholder="Province"  value="@if($acc!=''){{ $acc[0]->state }}@endif">
              </div>
            </div>  
            
            <input type="hidden" name="type" value="contact">
            <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
            <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
          </div>
          <div class="col-md-6">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Country</label>
              <div class="col">
                <input readonly type="text" class="form-control country" name="country" aria-describedby="emailHelp" placeholder="Country"  value="@if($acc!=''){{ $acc[0]->country }}@endif">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">ZIP Code</label>
              <div class="col">
                <input readonly type="text" class="form-control zipcode" name="zipcode" aria-describedby="emailHelp" placeholder="ZIP Code"  value="@if($acc!=''){{ $acc[0]->zipcode }}@endif">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">E-mail</label>
              <div class="col">
                <input readonly type="email" class="form-control email" name="email" aria-describedby="emailHelp" placeholder="Email" value="@if($acc!=''){{ $acc[0]->email }}@endif">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Website</label>
              <div class="col">
                <input readonly type="text" class="form-control website" name="website" aria-describedby="emailHelp" placeholder="" value="@if($acc!=''){{ $acc[0]->website }}@endif">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Phone</label>
              <div class="col">
                <input readonly type="text" class="form-control phone" name="phone" aria-describedby="emailHelp" placeholder="" value="@if($acc!=''){{ $acc[0]->phone }}@endif">
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
                <input type="text" class="form-control" name="pic_contact" placeholder="PIC Name" value="">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">PIC E-Mail</label>
              <div class="col">
                <input type="email" class="form-control" name="pic_email" aria-describedby="emailHelp" placeholder="Email" value="">
              </div>
            </div>  
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">PIC Mobile</label>
              <div class="col">
                <input type="text" class="form-control" name="pic_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber" value="">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">PIC Phone</label>
              <div class="col">
                <input type="text" class="form-control" name="pic_phone" aria-describedby="emailHelp" placeholder="Phone Number" value="">
              </div>
            </div>
            
          </div>
          <div class="col-md-6">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Billing Name</label>
              <div class="col">
                <input type="text" class="form-control" name="billing_contact" placeholder="PIC Name" value="">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Billing E-Mail</label>
              <div class="col">
                <input type="email" class="form-control" name="billing_email" aria-describedby="emailHelp" placeholder="Email" value="">
              </div>
            </div>  
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Billing Mobile</label>
              <div class="col">
                <input type="text" class="form-control" name="billing_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber" value="">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Billing Phone</label>
              <div class="col">
                <input type="text" class="form-control" name="billing_phone" aria-describedby="emailHelp" placeholder="Phone Number" value="">
              </div>
            </div>
            
          </div>
        </div>
        
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <div class="card-header bg-blue-lt">
          <h3 class="card-title"> Property Information</h3>
        </div>
        <div class="card-body row">
          <div class="col-md-6">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property Name</label>
              <div class="col">
              <input type="text" class="form-control" name="property_name" placeholder="Property Name" value="" required>
              </div>
            </div> 
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property Address</label>
              <div class="col">
              <textarea class="form-control" name="property_address" placeholder=""></textarea>
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property City</label>
              <div class="col">
                <input type="text" class="form-control" name="property_city" placeholder="City Name" value="">
              </div>
            </div>
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property State/Province</label>
              <div class="col">
                <input type="text" class="form-control" name="property_state" aria-describedby="emailHelp" placeholder="Province" value="">
              </div>
            </div>  
            
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property Country</label>
              <div class="col">
                <input type="text" class="form-control" name="property_country" aria-describedby="emailHelp" placeholder="" value="">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Property ZIP Code</label>
              <div class="col">
                <input type="text" class="form-control" name="property_zipcode" aria-describedby="emailHelp" placeholder="" value="">
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Map Latitude</label>
              <div class="col">
              <input type="text" class="form-control" name="maplat" aria-describedby="emailHelp" placeholder="MAP Latitude" value="">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Map Longitude</label>
              <div class="col">
              <input type="text" class="form-control" name="maplong" aria-describedby="emailHelp" placeholder="MAP Longitude" value="">
              </div>
            </div>  
            <div class="form-group mb-3 row">
              <label class="form-label col-3 col-form-label">Google Map URL</label>
              <div class="col">
              <input type="text" class="form-control" name="gmapurl" aria-describedby="emailHelp" placeholder="Google Map URL" value="">
              </div>
            </div>
          
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
    //$(document).ready({
      $(document).on("change",'.accountid',function(){
      
        var option = $('option:selected', this).attr('data-dtl');
        var options=option.split("|");
        //console.log(options[0]);
        
        $('.address').text(options[0]);
        $('.city').val(options[1]);
        $('.state').val(options[2]);
        $('.country').val(options[3]);
        $('.zipcode').val(options[4]);
        $('.website').val(options[6]);
        $('.email').val(options[5]);
        $('.phone').val(options[7]);
        
        
      });  
    //});
    
      
  });
</script>
@endpush