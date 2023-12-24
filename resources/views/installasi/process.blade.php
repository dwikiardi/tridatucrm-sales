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
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->teknisia}} {{$Instalation[0]->teknisib}}
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Package</label>
                <div class="col" style="margin-top: 6px;">
                {{$Instalation[0]->service}}
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
          <input type="hidden" class="form-control lsprod" name="lsprod" value='<?php echo json_encode($mstock); ?>' readonly>
          <input type="hidden" class="form-control noseri" name="noseri" value='<?php echo json_encode($StocksNoSeri); ?>' readonly>
          <input type="hidden" class="form-control stockpos" name="stockpos" value='<?php echo json_encode($stockPos); ?>' readonly>
          <input type="hidden" class="form-control categories" name="categories" value='<?php echo json_encode($Category); ?>' readonly>
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
                  <td><input class="catID catID{{$i}}" type="hidden" name="catID[{{$i}}]" value="{{$i}}">{{$cat->category_name}}</td>
                  <td>
                    <select class="form-select stockid stockid-{{$i}}" name="stockid[{{$i}}]">
                    <option value="">-- Select One --</option>
                      @foreach($mstock as $stock)
                        @if($stock->categoryid == $cat->id)
                            <option data-dtl='{{$i}}|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|{{ $stock->stockid}}' value="{{ $stock->id }}">{{ $stock->stockid}}</option>
                        @endif
                      @endforeach
                    </select>
                  </td>
                  <td><input class="name-{{$i}}" type="text" name="ProductName[{{$i}}]" value=""></td>
                  <td>
                    <select style="min-width: 150px;" class="form-select status" name="status[{{$i}}]">
                      <option value="1">Dipinjamkan</option>
                      <option value="0">Di Jual</option>
                    </select>
                  </td>
                  <td class="onqty-{{$i}}"><input style="width: 75px;" class="qty-{{$i}} qty" type="text" name="qty[{{$i}}]"  data-ix="{{$i}}" value="0"><input class="qtytype qtytype-{{$i}}" type="hidden" name="qtytype[{{$i}}]" value="0"></td>
                  <td><input  style="width: 75px;" class="unit unit-{{$i}}" type="text" name="unit[{{$i}}]" value=""readonly></td>
                  <td><div class='mnoseri-{{$i}}'></div><input class="mserial mserial-{{$i}}" type="hidden" name="mserial[{{$i}}]" value="">
                  </td>
                  
                </tr>
                <?php
                $i++;
                ?>
                @endforeach

              </tbody>
              <tfooter>
                <tr class="index">
                  <td>&nbsp;</td>
                  <td>
                  <input type="hidden" class="form-control indexs" name="indexs" value="{{$i}}" readonly><a href="#" class="addrows  btn btn-primary">add New Rows</a>
                  </td>
                </tr>
              </tfooter>
              
              
            </table>
          </div>
          <!-- <input class="row" type="text" name="row" value="{{$i}}"> -->
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
    $('.stockid').select2({
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
      //console.log(options[0]);
      
      $('.name-'+options[0]).val(options[1]);
      $('.unit-'+options[0]).val(options[3]);
      $('.qtytype-'+options[0]).val(options[2]);
      $('.mserial-'+options[0]).val("");
      $('.mnoseri-'+options[0]).empty();
      $('.qty-'+options[0]).focus();
      if(options[2]==0){
        $('.seelist-'+options[0]).remove();
      }else{
        if($('.qty-'+options[0]).val()!=0 && $('.mserial-'+options[0]).val()!=""){
          $('.seelist-'+options[0]).remove();
          $('.onqty-'+options[0]).append('<a href="#" class="seelist seelist-'+options[0]+'" data-ix="'+options[0]+'">see list</a>');
        }
      }
      
    });
    $('.process').on("click",function(){
      var mydata=$('#myform').serializeArray();
      // $('.catID').each(function(i, obj) {
      //     console.log('index: ' + i + '; obj: ' + obj);
      // });
      var values = [];
      $('.catID').each(function(){
          values.push(this.value); 
      });

      var stockid = [];
      $('.stockid').each(function(){
        stockid.push(this.value); 
      });
      
      var status = [];
      $('.status').each(function(){
        status.push(this.value); 
      });
      
      var qty = [];
      $('.qty').each(function(){
        qty.push(this.value); 
      });
      var qtytype = [];
      $('.qtytype').each(function(){
        qtytype.push(this.value); 
      });
      
      var mserial = [];
      $('.mserial').each(function(){
        mserial.push(this.value); 
      });
      //use values after the loop
      
      var mydata = {
        id : $('.id').val(),
        row : $('.indexs').val(),
        catID : values ,
        stockid : stockid,
        status : status,
        qty : qty,
        mserial : mserial,
        qtytype : qtytype,
      };

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
          //console.log(response);
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
                //console.log(value.noseri);  
              }
              
            });
            $('.textlist').autocomplete({
              source: source
            });	
            $('.sindex').empty();
            $('.sindex').val(ix);
            $(".modal-btn").click(); 
            //callModals();
            $('.seelist-'+ix).remove();
            $('.onqty-'+ix).append('<a href="#" class="seelist seelist-'+ix+'" data-ix="'+ix+'">see list</a>');
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
      //console.log(duplicateElements);
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

    $(document).on('click','.seelist',function () {
      //console.log('see list');
      var ix=$(this).attr('data-ix');
      var series=$('.qtytype-' + ix).val();
      var arr=$('.qty-' + ix).val();
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
            //console.log(value.noseri);  
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
    });
    
    $('.addrows').on('click', function() {
      let ix = $('.indexs').val();
      $('.indexs').val(parseInt($('.indexs').val()) + 1);
      var options='';
      var category='';
      var text ='<tr class="ix-'+ix+'"><td>';
      //categories
      var categories=JSON.parse($('.categories').val());
      
      text=text + '<select class="form-select category category-{{$i}}" name="category[{{$i}}]"><option value="--">-- select one --</option>';
      $(categories).each(function(index, value){ //loop through your elements
        category += '<option  data-dtl="'+ix+'" value="'+ value.id +'">'+value.category_name+'</option>'; //add the option element as a string
      }); 
      text=text + category +'</select><input class="catID catID'+ix+'" type="hidden" name="catID['+ix+']" value="'+ix+'"></td><td> <select class="form-select stockid stockid-'+ix+'" name="stockid['+ix+']"><option>-- select one --</option>';

      var series=JSON.parse($('.lsprod').val());
      $(series).each(function(index, value){ //loop through your elements
            options += '<option data-dtl="'+ix+'|'+value.stockname+'|'+value.qtytype+'|'+value.unit+'|'+value.stockid+'" value="'+ value.id +'">'+value.stockname+'</option>'; //add the option element as a string
      });                        
      text=text + options; 

      text=text + '</select><input type="hidden" class=" stockcode-'+ix+'" name="stockcode['+ix+']" ></td>';
      text=text + '<td><input type="text" style="min-width: 150px;" class="name name-'+ix+'" name="name['+ix+']" placeholder="Stock Name"></td>';
      text=text + '<td><select style="min-width: 150px;" class="form-select status" name="status['+ix+']"><option value="1">Dipinjamkan</option> <option value="0">Di Jual</option></select></td>';
      text=text + '<td class="onqty-'+ix+'"><input type="text" class="qty qty-'+ix+'" style="width: 75px;" name="qty['+ix+']" data-ix="'+ix+'" placeholder="Qty" value="0"><input type="hidden" class="qtytype qtytype-'+ix+'" name="qtytype['+ix+']" ></td>';
      
      text=text + '<td><input type="text" style="width: 75px;" class="unit unit-'+ix+'" name="unit['+ix+']" placeholder="Unit"readonly></td>';
      text=text + '<td><div class="mnoseri-'+ix+'"></div><input class="mserial mserial-'+ix+'" type="hidden" name="mserial['+ix+']" value=""></td>';
      
      
      $('.listItem').append(text);
    });

    $(document).on("change",'.category', function () {
      let ix = $('option:selected', this).attr('data-dtl');
      let filter = $('option:selected', this).val();
      var text="";
      var series=JSON.parse($('.lsprod').val());
      $(series).each(function(index, value){ //loop through your elements
        if(value.categoryid == filter){
          text=text + '<option data-dtl="'+ix+'|'+value.stockname+'|'+value.qtytype+'|'+value.unit+'|'+value.stockid+'" value="'+ value.id +'">'+value.stockname+'</option>'; //add the option element as a string
        }
      });
      //console.log(text);
      
      $(this).find('[value="--"]').remove();
      $('.stockid-'+ix).empty();
      $('.stockid-'+ix).append(text);
      $('.stockid-'+ix).select2({
      placeholder: 'Select an option'
    });
    });
  });
</script>
<style>
  ul.ui-autocomplete {
    z-index: 1100;
  }
</style>
@endpush