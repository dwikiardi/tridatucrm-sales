@extends('layouts/admin')
@section('title','Create New Instalation')

@section('content_header')
<!-- <form action="{{ route('installasi.store') }}" method="POST" enctype="multipart/form-data" id="myform">    -->
<form id="myform">   
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Instalation </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('installasi')}}" class="btn btn-light">« Kembali</a>                 
          <a href="#" class="btn btn-primary process">Simpan</a>
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
            <h3 class="card-title"> Instalation's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Customer</label>
                <div class="col">
                      <select class="form-select customer" name="customer">
                      
                       @foreach($Customers as $customer)
                          <option value="{{$customer->id}}" data-addr="{{$customer->property_address}}">{{$customer->property_name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>   
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control vaddress" name="vaddress" placeholder=""></textarea>
                </div>
              </div>
             
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Date</label>
                <div class="col">
                  
                  <div class='input-group date' id='datetimepicker' >
                    <input type='text' name='installasidate' id='installasidate' class="form-control date" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                
              </div>
              
              
              <input class="createby" type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input class="updateby" type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col">
                  <select class="form-select installerid" name="installerid">
                    @foreach($Users as $user)
                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Package</label>
                <div class="col">
                      <select class="form-select packageid" name="packageid">
                      
                       @foreach($services as $service)
                          <option value="{{$service->id}}" data-addr="{{$service->services_name}}">{{$service->services_name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>   
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col">
                <textarea class="form-control note" name="note" placeholder=""></textarea>
                </div>
              </div>  
              
            </div>
          </div>
          <div class="card-body row">
            <div class="col-12">
              <div class="form-group col-md-6 row">
                <label class="form-label col-3 col-form-label">IP Address</label>
                <div class="col">
                      <select class="form-select ipaddr" name="ipaddr">
                       @foreach($ipaddress as $ips)
                          <option value="{{$ips->id}}" data-addr="{{$ips->name}}">{{$ips->name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>   
              <div class="form-group col-md-6 row">
                <label class="form-label col-3 col-form-label">POP </label>
                <div class="col">
                      <select class="form-select pops" name="pops">
                       @foreach($pops as $pop)
                          <option value="{{$pop->id}}" data-addr="{{$pop->name}}">{{$pop->name}}</option>
                        @endforeach
                      </select>
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
      <a href="{{ url('installasi')}}" class="btn btn-light">« Kembali</a>                 
      <a href="#" class="btn btn-primary process">Simpan</a>
      </div>
    </div>
  </div>
</div>
</form>

@stop
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
  $(function () {
    
    $('.customer').on("change",function(){
      var text=$('.customer option:selected').attr("data-addr");
      //console.log(text);
      $('.vaddress').text(text);
    });
    $('.ipaddr').select2({
      placeholder: 'Select an option'
    });
    $('.pops').select2({
      placeholder: 'Select an option'
    });
    $('.customer').select2({
      placeholder: 'Select an option'
    });
    $('.packageid').select2({
      placeholder: 'Select an option'
    });
    
    $('.lsseri').select2({
      placeholder: 'Select an option'
    });
    $('.date').datetimepicker({format: 'DD/MM/YYYY',defaultDate:'now' });
    
   
    $('.process').on("click",function(){
      //var mydata=$('#myform').serializeArray();
      var mydata = $('#myform').serializeArray();
      console.log(mydata);
      $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      $('.process').attr("disabled", true);

      $.ajax({
        url: "{{route('installasi.store')}}",
        type: "POST",
        data: mydata,
        success: function( response ) {
          // $('.process').removeAttr('disabled');
          const obj = JSON.parse(response);
          if(obj.status ==="success"){
            window.location.href = obj.message;
          }
          if(obj.status ==="failed"){
            alert(obj.message);
          }
          //console.log(response);
        }
      });
    });
  });
</script>
@endpush