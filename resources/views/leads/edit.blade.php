@extends('layouts/admin')
@section('title','Create New Leads')

@section('content_header')
<form action="{{ route('leads.update') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Lead </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('leads/view',$leads[0]->id)}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Company's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid">
                        @foreach($Users as $user)
                          @if($user->id===  $leads[0]->ownerid)
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
                  <input type="text" class="form-control" name="leadsname" placeholder="Lead Name" value="{{$leads[0]->leadsname}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Company Name</label>
                <div class="col">
                  <input type="text" class="form-control company" name="account_name" placeholder="Company Name" value="{{$leads[0]->account_name}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="address" placeholder="">{{$leads[0]->address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">City</label>
                <div class="col">
                  <input type="text" class="form-control" name="city" placeholder="City"  value="{{$leads[0]->city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="state" aria-describedby="emailHelp" placeholder="Province"  value="{{$leads[0]->state}}">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="country" aria-describedby="emailHelp" placeholder="Country"  value="{{$leads[0]->country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="zipcode" aria-describedby="emailHelp" placeholder="ZIP Code"  value="{{$leads[0]->zipcode}}">
                </div>
              </div>
              
              <input type="hidden" name="accountid" id="accountid"  value="{{$leads[0]->accountid}}">
              <input type="hidden" name="id" id="id"  value="{{$leads[0]->id}}">
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">E-mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Email" value="{{$leads[0]->email}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Website</label>
                <div class="col">
                  <input type="text" class="form-control" name="website" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->website}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="phone" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->phone}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billing_address" placeholder="">{{$leads[0]->billing_address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_city" placeholder="City Name" value="{{$leads[0]->billing_city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_state" aria-describedby="emailHelp" placeholder="Province" value="{{$leads[0]->billing_state}}">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_country" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->billing_country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_zipcode" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->billing_zipcode}}">
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
                  <input type="text" class="form-control" name="pic_contact" placeholder="PIC Name" value="{{$leads[0]->pic_contact}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC E-Mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="pic_email" aria-describedby="emailHelp" placeholder="Email" value="{{$leads[0]->pic_email}}">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="pic_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber" value="{{$leads[0]->pic_mobile}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">PIC Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="pic_phone" aria-describedby="emailHelp" placeholder="Phone Number" value="{{$leads[0]->pic_phone}}">
                </div>
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_contact" placeholder="PIC Name" value="{{$leads[0]->billing_contact}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing E-Mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="billing_email" aria-describedby="emailHelp" placeholder="Email" value="{{$leads[0]->billing_email}}">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Mobile</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_mobile" aria-describedby="emailHelp" placeholder="Mobile Nomber" value="{{$leads[0]->billing_mobile}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="billing_phone" aria-describedby="emailHelp" placeholder="Phone Number" value="{{$leads[0]->billing_phone}}">
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
                <label class="form-label col-3 col-form-label">Property Address</label>
                <div class="col">
                <textarea class="form-control" name="property_address" placeholder="">{{$leads[0]->property_address}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Property City</label>
                <div class="col">
                  <input type="text" class="form-control" name="property_city" placeholder="City Name" value="{{$leads[0]->property_city}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Property State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="property_state" aria-describedby="emailHelp" placeholder="Province" value="{{$leads[0]->property_state}}">
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Property Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="property_country" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->property_country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Property ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="property_zipcode" aria-describedby="emailHelp" placeholder="" value="{{$leads[0]->property_zipcode}}">
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Latitude</label>
                <div class="col">
                <input type="text" class="form-control" name="maplat" aria-describedby="emailHelp" placeholder="MAP Latitude" value="{{$leads[0]->maplat}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Longitude</label>
                <div class="col">
                <input type="text" class="form-control" name="maplong" aria-describedby="emailHelp" placeholder="MAP Longitude" value="{{$leads[0]->maplong}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Google Map URL</label>
                <div class="col">
                <input type="text" class="form-control" name="gmapurl" aria-describedby="emailHelp" placeholder="Google Map URL" value="{{$leads[0]->gmapurl}}">
                </div>
              </div>
            
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead Status</label>
                <div class="col">
                  <select class="form-select" name="status">
                    <option 
                    @if($leads[0]->status=="New Contact")
                      selected
                    @endif 
                    value="New Contact">New Contact</option>
                    <option 
                    @if($leads[0]->status=="Future Contact")
                      selected
                    @endif 
                    value="Future Contact">Future Contact</option>
                    <option 
                    @if($leads[0]->status=="Tobe Contacted")
                      selected
                    @endif 
                    value="Tobe Contacted">Tobe Contacted</option>
                    <option 
                    @if($leads[0]->status=="Contacted")
                      selected
                    @endif 
                    value="Contacted">Contacted</option>
                    <option 
                    @if($leads[0]->status=="Waiting for Response")
                      selected
                    @endif 
                    value="Waiting for Response">Waiting for Response</option>
                    <option 
                    @if($leads[0]->status=="Cannot be Contacted")
                      selected
                    @endif 
                    value="Cannot be Contacted">Cannot be Contacted</option>
                  </select>
                </div>
              </div> 
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{$leads[0]->note}}</textarea>
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
        <a href="{{ url('leads/view',$leads[0]->id)}}" class="btn btn-light">« Kembali</a>                    
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