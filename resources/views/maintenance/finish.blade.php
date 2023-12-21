@extends('layouts/admin')
@section('title','Finish maintenance')

@section('content_header')
<!-- <form action="{{ route('maintenance.store') }}" method="POST" enctype="multipart/form-data" id="myform">    -->
<form id="myform">   
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Finish maintenance </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> maintenance's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col">
                {{$maintenance[0]->teknisia}} {{$maintenance[0]->teknisib}}
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
                {{$maintenance[0]->problem}}
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label"></label>
                <div class="col">
                    @if($maintenance[0]->reqstock ==1 )
                      [V] Request for Goods/Tools
                    @else
                      [ ] Request for Goods/Tools
                    @endif
                </div>
              </div>  
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Customer</label>
                <div class="col">
                {{$maintenance[0]->customer}}
                </div>
              </div>   
              <div class="form-group mb-3 row cdetail">
                <p><span>Address</span> : {{$maintenance[0]->address}}</p>
                <p><span>Contact</span> : {{$maintenance[0]->contact}} ( Mobile : {{$maintenance[0]->mobile}} )</p>
                <p><span>POPs</span> : {{$maintenance[0]->pops}}</p>
                <p><span>IP Address</span> : {{$maintenance[0]->ips}}</p>
              </div>
              
              
             
            </div>
            
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group col-md-12 row">
                <label class="form-label col-3 col-form-label">IP Address</label>
                <div class="col">
                  <select class="form-select ipaddr" name="ipaddr">
                    @foreach($ipaddress as $ipadd)
                    @if($maintenance[0]->ipid==$ipadd->id)
                      <option value="{{$ipadd->id}}" selected data-addr="{{$ipadd->name}}">{{$ipadd->name}}</option>  
                    @else
                      <option value="{{$ipadd->id}}" data-addr="{{$ipadd->name}}">{{$ipadd->name}}</option>
                    @endif
                      
                  @endforeach
                  </select>
                </div>
              </div>   
              <div class="form-group col-md-12 row">
                <label class="form-label col-3 col-form-label">POP </label>
                <div class="col">
                      <select class="form-select pops" name="pops">
                       @foreach($pops as $pop)
                        @if($maintenance[0]->ipid==$ipadd->id)
                          <option selected value="{{$pop->id}}" data-addr="{{$pop->name}}">{{$pop->name}}</option>
                        @else
                          <option value="{{$pop->id}}" data-addr="{{$pop->name}}">{{$pop->name}}</option>
                        @endif
                        
                        @endforeach
                      </select>
                </div>
              </div> 
              
            </div>
            <div class="col-md-6">
              <div class="form-group col-md-12 row">
                <label class="form-label col-3 col-form-label">Result</label>
                <div class="col">
                <textarea class="form-control result" name="result" placeholder="" required></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="table-responsive"  style="min-height: 150px;">
          <input type="hidden" class="form-control id" name="id" value='{{$maintenance[0]->id}}' readonly>
          <input type="hidden" class="form-control id" name="updatebyid" value='{{Auth::user()->id}}' readonly>
          <div class="form-group">
            Request for Goods/Tools
          </div>  
          <table class="table card-table table-vcenter text-nowrap datatable">
            <thead> 
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Status</th>
                <th>Allocation Qty</th>
                <th>Installed Qty</th>
                <th>Unit</th>
                <th>Installed NoSeri</th>
                
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody class='listItem'>
              
              @foreach($detail as $details)
              <tr>
                <td>
                <input class="details detail-{{$details->id}}" type="hidden" name="detail[]" value="{{$details->id}}">
                <input class="details detail-{{$details->id}}" type="hidden" name="stockid[{{$details->id}}]" value="{{$details->stockid}}">
                  {{$details->stockcodename}}
                </td>
                <td>{{$details->stocknames}}</td>
                <td>
                  <select style="max-width: 130px;" class="form-select status" name="status[{{$details->id}}]">
                    <option value="1">Dipinjamkan</option>
                    <option value="0">Di Jual</option>
                  </select>
                </td>
                <td>{{$details->qty}}</td>
                <td class="onqty-{{$details->id}}"><input style="width: 75px;" class="qty-{{$details->id}}" type="text" name="qty[{{$details->id}}]"  data-ix="{{$details->id}}" value="0"><input class="qtytype-{{$details->id}}" type="hidden" name="qtytype[{{$details->id}}]" value="{{$details->qtytype}}"></td>
                <td>{{$details->unit}}</td>
                <td>
                <?php
                if($details->serial != ''){
                  echo '<div>';
                  $noserials=explode(',',$details->serial);
                  foreach ($noserials as $noseri) {
                    ?>
                    <label class="form-check form-check-inline">
                      <input type="checkbox" name="installserial[{{$details->id}}][]" value="{{$noseri}}" class="form-check-input serials-{{$details->id}}">
                      <span class="form-check-label">{{$noseri}}</span>
                    </label>
                    <?php
                  }
                  echo '</div>';
                }
                ?>
                
                </td>
                
              </tr>
              
              @endforeach

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

          <div class="form-group">
            Installed On Customer
          </div>  
          <table class="table card-table table-vcenter text-nowrap datatable">
            <thead> 
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Installed Qty</th>
                <th>Revocation Qty</th>
                <th>Unit</th>
                <th>Revocation NoSeri</th>
                
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody class='listItem'>
              
              @foreach($installed as $install)
              <tr>
                <td>
                <input class="install install-{{$install->id}}" type="hidden" name="detaili[]" value="{{$install->id}}">
                <input type="hidden" name="stockidi[{{$install->id}}]" value="{{$install->id}}">
                  {{$install->stockcodename}}
                </td>
                <td>{{$install->stockname}}</td>
                <td>{{$install->qty}}</td>
                <td class="onqty-{{$install->id}}"><input style="width: 75px;" class="qtyi-{{$install->id}}" type="text" name="qtyi[{{$install->id}}]"  data-ix="{{$install->id}}" value="0"><input class="qtytypei-{{$install->id}}" type="hidden" name="qtytypei[{{$install->id}}]" value="{{$install->qtytype}}"></td>
                <td>{{$install->unit}}</td>
                <td>
                <?php
                if($install->noseri != ''){
                  echo '<div>';
                  $noserials=explode(',',$install->noseri);
                  foreach ($noserials as $noseri) {
                    ?>
                    <label class="form-check form-check-inline">
                      <input type="checkbox" name="installseriali[{{$install->id}}][]" value="{{$noseri}}" class="form-check-input serialsi-{{$install->id}}">
                      <span class="form-check-label">{{$noseri}}</span>
                    </label>
                    <?php
                  }
                  echo '</div>';
                }
                ?>
                
                </td>
                
              </tr>
              
              @endforeach

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
      <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a>                 
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
      var validi=validasi();
      if(valid==true){
        if(validi==true){
          $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
          });
          // $('.process').attr("disabled", true);

          $.ajax({
            url: "{{route('maintenance.refinish')}}",
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
            
            }
          });
        }
      }
      
    });

    function validate(){
      // var series=$('.qtytype-' + ix).val();
      // var count=$('.qtytype-' + ix).val();
      
      let returns=true;
      
      $('.details').each(function() {
        let ix= $(this).val();
        if( $('.qtytype-'+ix).val()==1){
          let total=0;
          let item="";
          $('.serials-'+ix+':checkbox:checked').each(function () {
              total++;
          });
          if(total != $('.qty-'+ix).val()){
            returns=false;
          }
        }
        
      });
      if  (returns == false){
        alert('Some Installed Qty not same with Checked Serial Number');
      }
      return returns;
    }
    function validasi(){
      let returns=true;
      $('.install').each(function() {
        let ix= $(this).val();
        if( $('.qtytypei-'+ix).val()==1){
          let total=0;
          let item="";
          $('.serialsi-'+ix+':checkbox:checked').each(function () {
              total++;
          });
          if(total != $('.qtyi-'+ix).val()){
            returns=false;
          }
        }
        
      });
      if  (returns == false){
        alert('Some Revocation Qty not same with Checked Serial Number');
      }
      return returns;
    }
   
  });
</script>

@endpush