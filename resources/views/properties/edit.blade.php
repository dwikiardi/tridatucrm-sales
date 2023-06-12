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
          <a href="{{ route('properties.view',$properties[0]->id)}}" class="btn btn-light">« Kembali</a>                 
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
                <label class="form-label col-3 col-form-label">Property Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid"  id="ownerid" required>
                        @foreach($Users as $user)
                          @if($user->id=== $properties[0]->id)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Account </label>
                <div class="col">
                      <select class="form-select" name="accountid"  id="accountid" required>
                      <option value=""> -- Select -- </option>
                       
                          @foreach($accounts as $account)
                            @if($properties[0]->accountid == $account->id)
                              <option selected value="{{ $account->id }}">{{ $account->fullname}} </option>
                            @else
                              <option  value="{{ $account->id }}">{{ $account->fullname}} </option>
                            @endif
                          @endforeach
                       
                      </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Contact </label>
                <div class="col">
                      <select class="form-select" name="contactid" id="contactid" required>
                          @foreach($contacts as $contact)
                            @if($properties[0]->contactid == $contact->id)
                              <option selected value="{{ $contact->id }}">{{ $contact->contactname}} </option>
                            @else
                              <option  value="{{ $contact->id }}">{{ $contact->contactname}} </option>
                            @endif
                          @endforeach
                      </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Property Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="propertyname" placeholder="Property Name" required>
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
                  <input type="text" class="form-control" name="zicode" aria-describedby="emailHelp" placeholder="">
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
                <label class="form-label col-3 col-form-label">Google Map Url</label>
                <div class="col">
                  <input type="email" class="form-control" name="mapurl" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Latitude</label>
                <div class="col">
                  <input type="text" class="form-control" name="maplat" aria-describedby="emailHelp" placeholder="">
                </div>
              </div> 
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Map Longitude</label>
                <div class="col">
                  <input type="email" class="form-control" name="maplong" aria-describedby="emailHelp" placeholder="Email">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Package Request</label>
                <div class="col">
                      <select class="form-select" name="productid">
                      <option value=""> -- Select -- </option>
                        @foreach($products as $product)
                            <option  value="{{ $product->id }}">{{ $product->productname }} </option>
                        @endforeach
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
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Account Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
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
                  <input type="text" class="form-control" name="province" aria-describedby="emailHelp" placeholder="Province" value="{{$accounts[0]->province}}">
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
              
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Address</label>
                <div class="col">
                <textarea class="form-control" name="billingaddress" placeholder="">{{$accounts[0]->billingaddress}}</textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing  City</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcity" placeholder="City Name"value="{{$accounts[0]->billingcity}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing State/Province</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingprovince" aria-describedby="emailHelp" placeholder="Province" value="{{$accounts[0]->province}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Country</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingcountry" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->country}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing ZIP Code</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingzipcode" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->billingzipcode}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing E-Mail</label>
                <div class="col">
                  <input type="email" class="form-control" name="billingemail" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->billingemail}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Fax</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingfax" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->billingfax}}">
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Billing Phone</label>
                <div class="col">
                  <input type="text" class="form-control" name="billingphone" aria-describedby="emailHelp" placeholder="" value="{{$accounts[0]->billingphone}}">
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
        <a href="{{ route('properties.view',$properties[0]->id)}}" class="btn btn-light">« Kembali</a>             
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
      
    var URI = "{{ url('/') }}";
    $('#accountid').on("change", function(e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var urls = URI + "/properties/getcontact/" + $('#accountid').val();
        $.ajax({
            url: urls,
            method: 'get',

            success: function(result) {
                //console.log(result);
                $('#contactid').empty();
                var data = JSON.parse(result);
                //$('#contact').append('<option value="--"> -- Pilih Kabupaten/Kota -- </option>');
                $.each(data, function(i, value) {
                    //console.log(value.name);
                    $('#contactid').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            }
        });
      });
      
  });
</script>
@endpush