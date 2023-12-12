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
                <div class="col" style="margin-top: 6px;">
                  {{$Instalation[0]->date}}
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
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->ips}} 
                </div>
                </div>
              </div>   
              <div class="form-group col-md-6 row">
                <label class="form-label col-3 col-form-label">POP </label>
                <div class="col">
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->pops}}
                </div>
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
                  <th>Category</th>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Status</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>NoSeri</th>
                  
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody class='listItem'>
                <?php
                $i=0;
                ?>
                @foreach($Category as $cat)
                <tr>
                  <td><input class="catID{{$i}}" type="hidden" name="catID[{{$i}}]" value="{{$i}}">{{$cat->category_name}}</td>
                  <td>
                    <select class="form-select stockid stockid-{{$cat->id}}" name="stockid[]">
                    <option value="">-- Select One --</option>
                      @foreach($mstock as $stock)
                        @if($stock->categoryid == $cat->id)
                            <option data-dtl='{{$cat->id}}|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|{{ $stock->stockid}}' value="{{ $stock->id }}">{{ $stock->stockid}}</option>
                        @endif
                      @endforeach
                    </select>
                  </td>
                  <td><input class="name-{{$cat->id}}" type="text" name="ProductName[]" value=""></td>
                  <td>
                    <select style="min-width: 150px;" class="form-select status" name="status[]">
                      <option value="1">Dipinjamkan</option>
                      <option value="0">Di Jual</option>
                    </select>
                  </td>
                  <td class="onqty-{{$cat->id}}"><input style="width: 75px;" class="qty-{{$cat->id}} qty" type="text" name="qty[]"  data-ix="{{$cat->id}}" value="0"><input class="qtytype-{{$cat->id}}" type="hidden" name="qtytype[]" value="0"></td>
                  <td><input  style="width: 75px;" class="unit-{{$cat->id}}" type="text" name="unit[]" value=""readonly></td>
                  <td><div class='mnoseri-{{$cat->id}}'></div><input class="mserial-{{$cat->id}}" type="hidden" name="mserial[]" value="">
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
          <input class="row" type="hidden" name="row" value="{{$i}}">
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

<!-- Modal -->
<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="popupLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popupLabel">Input Serial Number</h5>
        <td><input type="hidden" class="form-control sindex sindex-0" name="sindex"  readonly></td>
      </div>
      <div class="modal-body">
              <table>
                <thead>
                  <tr>
                    <th>Serial Number</th>
                  </tr>
                </thead>
                <tbody class="lsSerial">

                </tbody>
                
              </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveserial" >Save changes</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary hide modal-btn" data-toggle="modal" data-target="#popup">
</button>
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
    var lisNoseries=JSON.parse($('.noseri').val());
    
    
    
    
    $('.ipaddr').select2({
      placeholder: 'Select an option'
    });
    $('.pops').select2({
      placeholder: 'Select an option'
    });
   
    $('.lsseri').select2({
      placeholder: 'Select an option'
    });
    $('.date').datetimepicker({format: 'DD/MM/YYYY',defaultDate:'now' });
    $('.testauto').autocomplete({
      source:lisNoseries
    });
    $(document).on("change",'.stockid', function () {
      var option = $('option:selected', this).attr('data-dtl');
      var options=option.split("|");
      console.log(options[0]);
      
      $('.name-'+options[0]).val(options[1]);
      $('.unit-'+options[0]).val(options[3]);
      $('.qtytype-'+options[0]).val(options[2]);
      $('.qty-'+options[0]).focus();
      if(options[2]==0){
        $('.seelist-'+options[0]).remove();
      }else{
        if($('.qty-'+options[0]).val()!=0){
          $('.seelist-'+options[0]).remove();
          $('.onqty-'+options[0]).append('<a href="#" class="seelist seelist-'+options[0]+'" data-ix="'+options[0]+'">see list</a>');
        }
      }
      
    });
    $('.process').on("click",function(){
      //var mydata=$('#myform').serializeArray();
      var mydata = $('#myform').serializeArray();
      console.log(mydata);
      $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      // $('.process').attr("disabled", true);

      $.ajax({
        url: "{{route('installasi.reprocess')}}",
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
    });

    $(document).on('keypress','.qty',function(e) {
      var ix=$(this).attr('data-ix');
      var arr=$(this).val();
      if(e.which == 13) {
        if(arr <=0){
          alert('Quantity tidak boleh lebih kecil dari 1');
        }else{
          var series=$('.qtytype-' + ix).val();
          var list="";
          if(series == '1'){
            var exsist=$('.mserial-'+ix).val();
            if(exsist === undefined || exsist === null || exsist === ''){
              for(let i=0;i<arr;i++){
                list= list + '<tr><td><input type="text" class="form-control textlist list-0" name="list['+i+']" placeholder="Serial Number"></td></tr>';
              }
              
            }else{
              var datals=exsist.split(',');
              for(let i=0;i<arr;i++){
                if(datals[i] === undefined){
                  datals[i]="";
                }
                list= list + '<tr><td><input type="text" class="form-control textlist list-0" name="list['+i+']" placeholder="Serial Number" value="'+ datals[i] +'"></td></tr>';
              }
            }
            $('.lsSerial').empty();
            $('.lsSerial').append(list);
            var source=[];
            $.each(lisNoseries,function(index,value) {
              if(value.stockid == $('.stockid-' + ix).find(":selected").val()){
                source.push(value.noseri);
                console.log(value.noseri);  
              }
              
            });
            $('.textlist').autocomplete({
              source: source
            });	
            $('.sindex').empty();
            $('.sindex').val(ix);
            $(".modal-btn").click(); 
            //callModals();
          }
        }
        return false;
      
      }
        
    });

    $('.saveserial').on('click',function () {
      var taskArray = new Array();
      let nlist="";var listview="";
      $("input[name^=list]").each(function() {
        taskArray.push($(this).val());
        nlist =nlist + ',' + $(this).val();
        listview =listview  + $(this).val()+ ',<br>';
      });
      //check if Exist
      nlist=nlist.substring(1);
      
      const duplicateElements = toFindDuplicates(taskArray);
      if(duplicateElements.length >0){
        alert("it's duplicate : \n" + duplicateElements);
      }else{
        //nlist=nlist.substring(1);
        var option = $('.sindex').val();
        $('.mserial-'+option).val('');
        $('.mserial-'+option).val(nlist);
        $('.mnoseri-'+option).empty();
        $('.mnoseri-'+option).append(listview);
        $(".modal-btn").click(); 
      }
      console.log(duplicateElements);
    });

    function toFindDuplicates(arry) {
        const uniqueElements = new Set(arry);
        const filteredElements = arry.filter(item => {
            if (uniqueElements.has(item)) {
                uniqueElements.delete(item);
            } else {
                return item;
            }
        });
        return filteredElements;
        //return [...new Set(uniqueElements)]
    }

  });
</script>
<style>
  ul.ui-autocomplete {
    z-index: 1100;
  }
</style>
@endpush