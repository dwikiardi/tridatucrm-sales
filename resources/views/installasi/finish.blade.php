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
                <div class="col" style="margin-top: 6px;">
                     {{ $Instalation[0]->customer}}
                </div>
              </div>   
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->address}}
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
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technision</label>
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->teknisia}} {{$Instalation[0]->teknisib}}
                </div>
              </div>
                  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Note</label>
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->note}}
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
                    @foreach($ipaddress as $ipadd)
                    @if($Instalation[0]->ipid==$ipadd->id)
                      <option value="{{$ipadd->id}}" selected data-addr="{{$ipadd->name}}">{{$ipadd->name}}</option>  
                    @else
                      <option value="{{$ipadd->id}}" data-addr="{{$ipadd->name}}">{{$ipadd->name}}</option>
                    @endif
                      
                  @endforeach
                  </select>
                </div>
              </div>   
              <div class="form-group col-md-6 row">
                <label class="form-label col-3 col-form-label">POP </label>
                <div class="col">
                      <select class="form-select pops" name="pops">
                       @foreach($pops as $pop)
                        @if($Instalation[0]->ipid==$ipadd->id)
                          <option selected value="{{$pop->id}}" data-addr="{{$pop->name}}">{{$pop->name}}</option>
                        @else
                          <option value="{{$pop->id}}" data-addr="{{$pop->name}}">{{$pop->name}}</option>
                        @endif
                        
                        @endforeach
                      </select>
                </div>
              </div>   
          </div>
        </div>
        <div class="card">
          <div class="table-responsive"  style="min-height: 150px;">
          <input type="hidden" class="form-control id" name="id" value='{{$Instalation[0]->id}}' readonly>
          <input type="hidden" class="form-control lsprod" name="lsprod" value='<?php echo json_encode($Stocks); ?>' readonly>
          <input type="hidden" class="form-control noseri" name="noseri" value='<?php echo json_encode($StocksNoSeri); ?>' readonly>
          <input type="hidden" class="form-control stockpos" name="stockpos" value='<?php echo json_encode($stockPos); ?>' readonly>
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead> 
                <tr>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Status</th>
                  <th>Installed Qty</th>
                  <th>Unit</th>
                  <th>NoSeri</th>
                  
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody class='listItem'>
                <?php
                $i=0;
                ?>
                @foreach($detail as $details)
                <tr>
                  <td>
                  <input class="details detail-{{$details->id}}" type="hidden" name="detail[]" value="{{$details->id}}">
                    <!-- <select class="form-select stockid stockid-{{$details->id}}" name="stockid[]">
                    <option value="">-- Select One --</option>
                      @foreach($mstock as $stock)
                        @if($stock->id == $details->stockid)
                          <option selected data-dtl='{{$details->id}}|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|{{ $stock->stockid}}' value="{{ $stock->id }}">{{ $stock->stockid}}</option>
                        @else
                        <option data-dtl='{{$details->id}}|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|{{ $stock->stockid}}' value="{{ $stock->id }}">{{ $stock->stockid}}</option>
                        @endif
                      @endforeach
                    </select> -->
                    {{$details->stockid}}
                    <input class="details detail-{{$details->id}}" type="hidden" name="stockid[]" value="{{$details->stockid}}">
                  </td>
                  <td>{{$details->stockid}}</td>
                  <td>
                    <select style="max-width: 130px;" class="form-select status" name="status[{{$details->id}}]">
                      <option value="1">Dipinjamkan</option>
                      <option value="0">Di Jual</option>
                    </select>
                  </td>
                  <td class="onqty-{{$details->id}}"><input style="width: 75px;" class="qty-{{$details->id}}" type="text" name="qty[{{$details->id}}]"  data-ix="{{$details->id}}" value="{{$details->qty}}"><input class="qtytype-{{$details->id}}" type="hidden" name="qtytype[{{$details->id}}]" value="{{$details->qtytype}}"></td>
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
                <?php
                $i++;
                ?>
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
        console.log(mydata);
        $.ajaxSetup({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        // $('.process').attr("disabled", true);

        $.ajax({
          url: "{{route('installasi.refinish')}}",
          type: "POST",
          data: mydata,
          success: function( response ) {
            $('.process').removeAttr('disabled');
            const obj = JSON.parse(response);
            if(obj.status ==="success"){
              window.location.href = obj.message;
            }
           
          }
        });
      }
      
    });

    $(document).on('keypress','.qty',function(e) {
      var ix=$(this).attr('data-ix');
      var arr=$(this).val();
      if(e.which == 13) {
        if(arr <=0){
          alert('Quantity tidak boleh lebih kecil dari 1');
          return false;
        }else{
          let valid=validate();
          console.log('return: ' + valid);
          return false;
        }
      
      }
    });

    function validate(){
      // var series=$('.qtytype-' + ix).val();
      // var count=$('.qtytype-' + ix).val();
      
      let returns=true;
      console.log($('#rows').val());
      if($('#rows').val()>1){
        console.log('more than 1 row');
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
          alert('Some Instaled Qty not same with Checked Serial Number');
        }
        return returns;
      }else{
        var ix= $('.details').val();
        let total=0;
        if( $('.qtytype-'+ix).val()==1){
          $('.serials-'+ix+':checkbox:checked').each(function () {
              // item=item + $(this).val() +',';
              total++;
          });
        }
        if(total != $('.qty-'+ix).val()){
          alert('Instaled Qty not same with Chacked Serial');
          returns=false;
        }
      }
      return returns;
    }
   
  });
</script>

@endpush