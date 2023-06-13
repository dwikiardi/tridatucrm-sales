@extends('layouts/admin')
@section('title','Create New Deals')

@section('content_header')
<form action="{{ route('deals.store') }}" method="POST">    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Deal </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('deals')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Deal Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Deal Owner</label>
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
                <label class="form-label col-3 col-form-label">Deal Date</label>
                <div class="col">
                  <div class='input-group date' id='datetimepicker' >
                      <input type='text' name='date' class="form-control" />
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Deal Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="dealname" placeholder="Deal Name">
                  
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Customer From</label>
                <div class="col">
                      <select class="form-select" name="dealtype" id="dealtype">
                        <option>-- Select one --</option>
                        <option value="1">LEAD</option>
                        <option value="2">Properties</option>
                      </select>
                </div>
              </div>   
              <div class="form-group mb-3 row lead">
                <label class="form-label col-3 form-label">Select Lead</label>
                <div class="col">
                      <select class="form-select" name="leads" id="leads">
                      <option>-- Select one --</option>
                        @foreach($leads as $lead)
                          <option  value="{{ $lead->id }}">{{ $lead->leadsname}}</option>
                        @endforeach
                      </select>
                </div>
              </div> 
              <div class="form-group mb-3 row property">
                <label class="form-label col-3 col-form-label">Select Property</label>
                <div class="col">
                      <select class="form-select" name="properties" id="properties">
                      <option>-- Select one --</option>
                        @foreach($properties as $property)
                            <option  value="{{ $property->id }}">{{ $property->propertyname}}</option>
                        @endforeach
                      </select>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Select Product</label>
                <div class="col">
                      <select class="form-select" name="productid" id="productid">
                      <option>-- Select one --</option>
                        @foreach($Products as $product)
                            <option  value="{{ $product->id }}" data-name="{{$product->productname}}" data-price="{{$product->price}}">{{ $product->productname}}</option>
                        @endforeach
                      </select>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Stage</label>
                <div class="col">
                      <select class="form-select" name="stage" id="stage">
                      <option  value="Qualification">Qualification</option>
                      <option  value="Need Analysis">Need Analysis</option>
                      <option  value="Quote">Quote</option>
                      <option  value="Price Review">Price Review</option>
                      <option  value="Close Won">Close Won</option>
                      <option  value="Close Lost">Close Lost</option>
                      </select>
                </div>
              </div>  
              
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="leadid" id="leadid" value="">
              <input type="hidden" name="contactid" id="contactid" value="">
              <input type="hidden" name="accountid" id="accountid" value="">
              <input type="hidden" name="propertiesid" id="propertiesid" value="">
              <input type="hidden" name="price" id="price" value="">
            </div>
            <div class="card col-md-6" style=" padding: 0!important;width: calc(50% - 5px);">
              <div class="card-header">
                <h3 class="card-title"> Information Detail</h3>
              </div>
              <div class="card-body">
                <div class="col-md-12 details">
                </div>
              </div>
              <div class="card-header" style=" border-top: 1px solid rgba(98,105,118,.16);">
                <h3 class="card-title"> Product Detail</h3>
              </div>
              <div class="card-body">
                <div class="col-md-12 products">
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
      <a href="{{ url('deals')}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>
@stop
@push('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css" rel="stylesheet"/>
<style>
  .hides{
    display:none;
  }
  .shows{
    display:flex;
  }
  .details .form-group,.products .form-group{
    margin:0!important;
  }
  .details .form-label,.products .form-label{
    padding:0!important;
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


<script type="text/javascript">
  $(function () {
    var URI = "{{ url('/') }}";
    $('.lead').addClass('hides');
    $('.property').addClass('hides');
    $('#datetimepicker').datetimepicker({format: 'DD/MM/YYYY'});
    $(document).on('change','#dealtype', function(){
      $('.show').removeClass();
      
      if($(this).val()=="1"){
        $('.lead').addClass('shows');
        $('.property').addClass('hides');
        $('.lead').removeClass('hides');
        $('.property').removeClass('shows');
      }
      if($(this).val()=="2"){
        $('.lead').addClass('hides');
        $('.property').addClass('shows');
        $('.lead').removeClass('shows');
        $('.property').removeClass('hides');
      }
    });
    $(document).on('change','#leads', function(e){
      e.preventDefault();
      var id=$(this).val()
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var urls = URI + "/deals/getlead/" + id;
      $.ajax({
          url: urls,
          method: 'get',

          success: function(result) {
            $('.details').empty();
            var data = JSON.parse(result);
            var htmls="";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Company</label><div class=\"col\">" + data[0]['company'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Contact</label><div class=\"col\">" + data[0]['first_name'] +" " + data[0]['first_name'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Address</label><div class=\"col\">" + data[0]['address'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">E-Mail</label><div class=\"col\">" + data[0]['email'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Number</label><div class=\"col\">" + data[0]['phone'] +"</div></div>  ";
            $('.details').append(htmls);
            $('#accountid').val('');
            $('#contactid').val('');
            $('#propertiesid').val('');
            $('#leadid').val(data[0]['id']);
            //console.log(data['leadsname']);
            
          }
      });
    });
    $(document).on('change','#properties', function(e){
      e.preventDefault();
      var id=$(this).val()
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
      });
      var urls = URI + "/deals/getproperty/" + id;
      $.ajax({
          url: urls,
          method: 'get',

          success: function(result) {
            $('.details').empty();
            var data = JSON.parse(result);
            var htmls="";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Company</label><div class=\"col\">" + data[0]['Accounts'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Contact</label><div class=\"col\">" + data[0]['Contacts']  +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Address</label><div class=\"col\">" + data[0]['address'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">E-Mail</label><div class=\"col\">" + data[0]['email'] +"</div></div>  ";
            htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Number</label><div class=\"col\">" + data[0]['mobile'] +"</div></div>  ";
            $('.details').append(htmls);
            $('#accountid').val(data[0]['accountid']);
            $('#contactid').val(data[0]['contactid']);
            $('#propertiesid').val(data[0]['id']);
            $('#leadid').val('');
          }
      });
    });
    $(document).on('change','#productid', function(e){
      e.preventDefault();
      var name=$(this).find(':selected').attr('data-name');
      var price=$(this).find(':selected').attr('data-price');
      //console.log(name);
      $('.products').empty();
      var htmls="";
      htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Product Name</label><div class=\"col\">" + name +"</div></div>  ";
      htmls=htmls+"<div class=\"form-group mb-3 row\"><label class=\"form-label col-3 col-form-label\">Price</label><div class=\"col\">" + price  +"</div></div>  ";
      $('.products').append(htmls);
      $('#price').val(price);
      
    });
  });
</script>
@endpush