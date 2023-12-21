@extends('layouts/admin')
@section('title','Finish Revocation')

@section('content_header')
<!-- <form action="{{ route('revocation.store') }}" method="POST" enctype="multipart/form-data" id="myform">    -->
<form id="myform">   
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Finish Revocation </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('revocation')}}" class="btn btn-light">« Kembali</a>                 
          <a class="btn btn-primary process">Simpan</a>
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
            <h3 class="card-title"> Revocation's Information</h3>
          </div>
          <div class="card-body row">
            
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Customer</label>
                <div class="col">
                <p>{{$revocation[0]->customer}}</p>
                </div>
              </div>   
              <div class="form-group mb-3 row cdetail">
                <label class="form-label col-3 col-form-label">Customer Detail</label>
                <div class="col">
                <p><span>Address</span> : {{$revocation[0]->address}}</p>
                <p><span>Contact</span> : {{$revocation[0]->contact}} ( Mobile : {{$revocation[0]->mobile}} )</p>
                <p><span>POPs</span> : {{$revocation[0]->pops}}</p>
                <p><span>IP Address</span> : {{$revocation[0]->ips}}</p>
                </div>
              </div>
              
              
             
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col">
                {{$revocation[0]->teknisia}} {{$revocation[0]->teknisib}}
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Date</label>
                <div class="col">
                {{$revocation[0]->date}}
                </div>
                
              </div>
              
            </div>
          </div>
        </div>

        <div class="card">
          <div class="table-responsive"  style="min-height: 150px;">
          <input type="hidden" class="form-control id" name="id" value='{{$revocation[0]->id}}' readonly>
          <input type="hidden" class="form-control id" name="updatebyid" value='{{Auth::user()->id}}' readonly>
            
          <table class="table card-table table-vcenter text-nowrap datatable">
            <thead> 
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Status</th>
                <th>Installed Qty</th>
                <th>Revocation Qty</th>
                <th>Unit</th>
                <th>Revocation NoSeri</th>
                
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody class='listItem'>
              <?php  $i=0; ?>
              @foreach($detail as $details)
              <tr>
                <td>
                <input class="details detail-{{$i}}" type="hidden" name="detail[]" value="{{$i}}">
                <input class="details detail-{{$i}}" type="hidden" name="stockid[{{$i}}]" value="{{$details->id}}">
                  {{$details->stockcodename}}
                </td>
                <td>{{$details->stockname}}</td>
                <td>
                  <select style="max-width: 130px;" class="form-select status" name="status[{{$i}}]">
                    <option value="1">Dipinjamkan</option>
                    <option value="0">Di Jual</option>
                  </select>
                </td>
                <td>{{$details->qty}}<input class="details iqty-{{$i}}" type="text" name="iqty[{{$i}}]" value="{{$details->qty}}"></td>
                <td class="onqty-{{$i}}"><input style="width: 75px;" class="qty-{{$i}}" type="text" name="qty[{{$i}}]"  data-ix="{{$i}}" value="0"><input class="qtytype-{{$i}}" type="hidden" name="qtytype[{{$i}}]" value="{{$details->qtytype}}"></td>
                <td>{{$details->unit}}</td>
                <td><input type="hidden" class="form-control inserial-{{$i}}" name="inserial[{{$i}}]" value="{{$details->noseri}}" readonly>
                <?php
                if($details->noseri != ''){
                  echo '<div>';
                  $noserials=explode(',',$details->noseri);
                  foreach ($noserials as $noseri) {
                    ?>
                    <label class="form-check form-check-inline">
                      <input type="checkbox" name="serials[{{$i}}][]" value="{{$noseri}}" class="form-check-input serials-{{$i}}">
                      <span class="form-check-label">{{$noseri}}</span>
                    </label>
                    <?php
                  }
                  echo '</div>';
                }
                ?>
                
                </td>
                
              </tr>
              <?php $i++;?>
              @endforeach
              <input type="hidden" class="form-control indexs" name="indexs" value="{{$i}}" readonly>
            </tbody>
            <!-- <tfooter>
              <tr class="index">
                <td>&nbsp;</td>
                <td>
                <input type="hidden" class="form-control indexs" name="indexs" value="0" readonly><a href="#" class="addrows  btn btn-primary">add New Rows</a>
                </td>
              </tr>
            </tfooter> -->
            
            
          </table>

         
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
      <a href="{{ url('revocation')}}" class="btn btn-light">« Kembali</a>                 
      <a class="btn btn-primary process">Simpan</a>
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

<link href="{{asset('public/libs/jqueryui/jquery-ui.css')}}" rel="stylesheet" />
<script src="{{asset('public/libs/jqueryui/jquery-ui.min.js')}}"></script>

<script type="text/javascript">
  $(function () {
   
    $('.ipaddr').select2({
      placeholder: 'Select an option'
    });
    $('.pops').select2({
      placeholder: 'Select an option'
    });
   
    $('.date').datetimepicker({format: 'DD/MM/YYYY',defaultDate:'now' });
    
    $('.process').on("click",function(){
      //var mydata=$('#myform').serializeArray();
      var mydata = $('#myform').serializeArray();
      var valid=validate();
      if(valid==true){
        $.ajaxSetup({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        // $('.process').attr("disabled", true);

        $.ajax({
          url: "{{route('revocation.refinish')}}",
          type: "POST",
          data: mydata,
          success: function( response ) {
            $('.process').removeAttr('disabled');
            const obj = JSON.parse(response);
            if(obj.status ==="success"){
              window.location.href = obj.message;
            }
            if(obj.status ==="failed"){
              alert(obj.message);
            }
              console.log(response);
          }
        });
        
      }
      
    });

    function validate(){
      // var series=$('.qtytype-' + ix).val();
      // var count=$('.qtytype-' + ix).val();
      
      let returns=true;
      let serial=true;
      let qty=0;
      $('.details').each(function() {
        let ix= $(this).val();
        if( $('.qtytype-'+ix).val()==1){
          let total=0;
          let item="";
          $('.serials-'+ix+':checkbox:checked').each(function () {
              total++;
          });
          if(total != $('.qty-'+ix).val()){
            serial=false;
          }
        }
        if($('.iqty-'+ix).val() < $('.qty-'+ix).val()){
          qty=qty+1;
        }
      });
      if  (serial == false){
        alert('Some Revocation Qty not same with Checked Serial Number');
        returns=false;
      }
      if  (qty > 0){
        alert('Some Revocation Qty is Greather installed qty');
        returns=false;
      }
      return returns;
    }
    
   
  });
</script>

@endpush