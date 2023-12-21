@extends('layouts/admin')
@section('title','Create New Maintenance')

@section('content_header')
<!-- <form action="{{ route('installasi.store') }}" method="POST" enctype="multipart/form-data" id="myform">    -->
<form id="myform">   
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Maintenance </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a>                 
          <a href="#" class="btn btn-primary process">Simpan</a>
        </div>
      </div>
    </div>
@stop
@section('content')
<style>
  .cdetail p span{
    padding: 0 15px 0 10px;
    font-weight: bold;
    width: 100px!important;
    display: inline-block;
  }
</style>
@csrf
<div class="container-xl">
  <div class="row row-cards" data-masonry='{"percentPosition": true }'>
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-blue-lt">
            <h3 class="card-title"> Maintenance's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col">
                  <select class="form-select staffid" name="staffid">
                    @foreach($Users as $user)
                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Date</label>
                <div class="col">
                  
                  <div class='input-group date' id='datetimepicker' >
                    <input type='text' name='date' id='date' class="form-control date" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Problem</label>
                <div class="col">
                <textarea class="form-control problem" name="problem" placeholder=""></textarea>
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label"></label>
                <div class="col">
                    <input type="checkbox" name="reqstock" value="1" class="form-check-input reqstock">
                    <span >Request for Goods/Tools</span>
                </div>
              </div>  
              <input class="createby" type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input class="updateby" type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Customer</label>
                <div class="col">
                      <select class="form-select customer" name="customer" required>
                        <option value="">-- Select One --</option>
                       @foreach($Customers as $customer)
                          <option value="{{$customer->id}}" data-addr="{{$customer->property_address}}" data-ip="{{$customer->ip_address}}" data-pop="{{$customer->popname}}" data-contact="{{$customer->pic_name}}" data-mobile="{{$customer->pic_mobile}}">{{$customer->property_name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>   
              <div class="form-group mb-3 row cdetail">
              
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
      <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a>                 
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
      var addr='<p><span>Address</span> : ' + $('.customer option:selected').attr("data-addr") + '</p>';
       addr=addr + '<p><span>Contact</span> : ' + $('.customer option:selected').attr("data-contact") + '( '+ $('.customer option:selected').attr("data-mobile") +' )</p>';
       addr=addr + '<p><span>POPs</span> : ' + $('.customer option:selected').attr("data-pop") + '</p>';
       addr=addr + '<p><span>IP Address</span> : ' + $('.customer option:selected').attr("data-ip") + '</p>';
      //console.log(text);
      $('.cdetail').empty();
      $('.cdetail').html(addr);
    });
    
    $('.customer').select2({
      placeholder: 'Select an option'
    });
   
    $('.date').datetimepicker({format: 'DD/MM/YYYY',defaultDate:'now' });
    
   
    $('.process').on("click",function(){
      //var mydata=$('#myform').serializeArray();
      var mydata = $('#myform').serializeArray();
      //console.log(mydata);
      var validate=valids();
      if(validate==true){
        $.ajaxSetup({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $('.process').attr("disabled", true);

        $.ajax({
          url: "{{route('maintenance.store')}}",
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
      }
      
    });

    function valids() {
      let returns=true;
      console.log($('.customer option:selected').val());
      if( !($('.customer option:selected').val())){
        alert('Please select Customer');
        returns=false;
      }
      console.log(returns);
      return returns;
    }

  });
</script>
@endpush