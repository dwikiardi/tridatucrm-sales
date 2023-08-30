@extends('layouts/admin')
@section('title','Create New Order')

@section('content_header')
<form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" id="myform">   
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Create New Order </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('order')}}" class="btn btn-light">« Kembali</a>                 
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
            <h3 class="card-title"> Order's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Orders Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="ordername" placeholder="Order Name">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Suppiler Inv.No</label>
                <div class="col">
                  <input type="text" class="form-control" name="supno" placeholder="Supplier Invoice Number">
                </div>
              </div>
             
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Date</label>
                <div class="col">
                  
                  <div class='input-group date' id='datetimepicker' >
                    <input type='text' name='orderdate' class="form-control date" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>
                </div>
                
              </div>
              
              
              
              <input type="hidden" name="createbyid" value="{{Auth::user()->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Vendors</label>
                <div class="col">
                      <select class="form-select vendorid" name="vendorid">
                      <option >-- Select One --</option>
                        @foreach($Vendor as $vendor)
                          <option  value="{{ $vendor->id }}" data-addr="{{$vendor->address}},{{$vendor->city}},{{$vendor->state}},{{$vendor->country}}">{{ $vendor->vendor_name}}</option>
                        @endforeach
                      </select>
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control vaddr" name="vaddress" placeholder=""></textarea>
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
        <div class="card">
            <div class="table-responsive"  style="min-height: 150px;">
            <input type="text" class="form-control lsprod" name="lsprod" value='<?php echo json_encode($Stocks); ?>' readonly>
              <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Total</th>
                    
                    <!-- <th>Action</th> -->
                  </tr>
                </thead>
                <tbody class='listItem'>
                  <tr class="ix-0">
                    <td> <a class="btn btn-danger remove hidden">x</a></td>
                    <td> <select class="form-select stockid stockid-0" name="stockid[0]">
                      <option>-- select one --</option>
                        @foreach($Stocks as $stock)
                            <option data-dtl='0|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|' value="{{ $stock->stockid }}">{{ $stock->stockname}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" class="form-control name name-0" name="name[0]" placeholder="Stock Name"></td>
                    <td><input type="text" class="form-control qty qty-0" name="qty[0]" data-ix="0" placeholder="Qty" value="0"><input type="text" class="form-control qtytype-0" name="qtytype[0]" ></td>
                    <td><input type="text" class="form-control price price-0" name="price[0]" data-ix="0" placeholder="Price" value="0"><input type="text" class="form-control lsnoseri-0" name="lsnoseri[0]" placeholder="List NoSeri"></td>
                    <td><input type="text" class="form-control unit unit-0" name="unit[0]" placeholder="Unit"readonly></td>
                    <td><input type="text" class="form-control total total-0" name="total[0]" placeholder="Total" readonly></td>
                  </tr>
                </tbody>
                <tfooter>
                  <tr class="index">
                    <td>&nbsp;</td>
                    <td>
                    <input type="text" class="form-control indexs" name="indexs" value="0" readonly><a href="#" class="addrows">add New Rows</a>
                    </td>
                  </tr>
                </tfooter>
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
      <a href="{{ url('leads')}}" class="btn btn-light">« Kembali</a>                 
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
        <td><input type="text" class="form-control sindex sindex-0" name="sindex"  readonly></td>
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
<script type="text/javascript">
  $(function () {
    
    $('.vendorid').on("change",function(){
      var text=$('.vendorid option:selected').attr("data-addr");
      //console.log(text);
      $('.vaddr').text(text);
    });

    $('.date').datetimepicker({format: 'DD/MM/YYYY'});
    //$('.stockid').on("change", function () {
    $(document).on("change",'.stockid', function () {
      var option = $('option:selected', this).attr('data-dtl');
      var options=option.split("|");
      //console.log(options[0]);
      
      $('.name-'+options[0]).val(options[1]);
      $('.qtytype-'+options[0]).val(options[2]);
      $('.unit-'+options[0]).val(options[3]);
      $('.qty-'+options[0]).focus();
    });
    
    $('.qty').on('keypress',function(e) {
        var ix=$(this).attr('data-ix');
        var arr=$(this).val();
        if(e.which == 13) {
          if(arr <=0){
            alert('Quantity tidak boleh lebih kecil dari 1');
          }else{
            var series=$('.qtytype-' + ix).val();
            var list="";
            if(series == '1'){
              var exsist=$('.lsnoseri-'+ix).val();
              if(exsist === undefined || exsist === null || exsist === ''){
                for(let i=1;i<=arr;i++){
                  list= list + '<tr><td><input type="text" class="form-control list list-0" name="list['+i+']" placeholder="Serial Number"></td></tr>';
                }
                
              }else{
                var datals=exsist.split(',');
                for(let i=1;i<=arr;i++){
                  list= list + '<tr><td><input type="text" class="form-control list list-0" name="list['+i+']" placeholder="Serial Number" value="'+ datals[i] +'"></td></tr>';
                }
              }
              $('.lsSerial').empty();
              $('.lsSerial').append(list);
              $('.sindex').empty();
              $('.sindex').val(ix);
              $(".modal-btn").click(); 
              $('.price-' + ix).focus();
              //callModals();
            }else{
              $('.price-' + ix).focus();
            }
          }
          //return false;
          
          
          return false;
        }
        
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
              var exsist=$('.lsnoseri-'+ix).val();
              if(exsist === undefined || exsist === null || exsist === ''){
                for(let i=1;i<=arr;i++){
                  list= list + '<tr><td><input type="text" class="form-control list list-0" name="list['+i+']" placeholder="Serial Number"></td></tr>';
                }
                
              }else{
                var datals=exsist.split(',');
                for(let i=1;i<=arr;i++){
                  list= list + '<tr><td><input type="text" class="form-control list list-0" name="list['+i+']" placeholder="Serial Number" value="'+ datals[i] +'"></td></tr>';
                }
              }
                $('.lsSerial').empty();
                $('.lsSerial').append(list);
                $('.sindex').empty();
                $('.sindex').val(ix);
                $(".modal-btn").click(); 
              //callModals();
            }else{
              $('.price-' + ix).focus();
            }
          }
          //return false;
          
          
          return false;
        }
        
    });
    $('.price').on('keypress',function(e) {
        var ix=$(this).attr('data-ix');
        //console.log();
        if(e.which == 13) {
          //console.log('enter Pressed');
          var total=getTotal(ix);
          $('.total-' + ix).val(total);
          return false;
        }
        
    });
    $(document).on('keypress','.price',function(e) {
        var ix=$(this).attr('data-ix');
        //console.log();
        if(e.which == 13) {
          //console.log('enter Pressed');
          var total=getTotal(ix);
          $('.total-' + ix).val(total);
          return false;
        }
        
    });
    $('#popup').modal({
      backdrop: 'static',
      keyboard: false  // to prevent closing with Esc button (if you want this too)
    });
    $('.saveserial').on('click',function () {
      var taskArray = new Array();
      let nlist="";
      $("input[name^=list]").each(function() {
        taskArray.push($(this).val());
        nlist =nlist + ',' + $(this).val();
        
      });
      const duplicateElements = toFindDuplicates(taskArray);
      if(duplicateElements.length >0){
        alert("it's duplicate : \n" + duplicateElements);
      }else{
        var option = $('.sindex').val();
        $('.lsnoseri-'+option).val('');
        $('.lsnoseri-'+option).val(nlist);
        $(".modal-btn").click(); 
        $('.price-' + option).focus();
      }
      console.log(duplicateElements);
    });
    $('.addrows').on('click', function() {
      let ix = parseInt($('.indexs').val()) + 1;
      $('.indexs').val(ix);
      var options='';
      var text ='<tr class="ix-'+ix+'"><td> <a class="btn btn-danger remove hidden">x</a></td><td> <select class="form-select stockid stockid-'+ix+'" name="stockid['+ix+']"><option>-- select one --</option>';
      var series=JSON.parse($('.lsprod').val());
      $(series).each(function(index, value){ //loop through your elements
        
            options += '<option data-dtl="'+ix+'|'+value.stockname+'|'+value.qtytype+'|'+value.unit+'" value="'+ value.stockid +'">'+value.stockname+'</option>'; //add the option element as a string
            
        
      });                        
      text=text + options;                      
      text=text + '</select></td>';
      text=text + '<td><input type="text" class="form-control name name-'+ix+'" name="name['+ix+']" placeholder="Stock Name"></td>';
      text=text + '<td><input type="text" class="form-control qty qty-'+ix+'" name="qty['+ix+']" data-ix="'+ix+'" placeholder="Qty" value="0"><input type="text" class="form-control qtytype-'+ix+'" name="qtytype['+ix+']" ></td>';
      text=text + '<td><input type="text" class="form-control price price-'+ix+'" name="price['+ix+']" data-ix="'+ix+'" placeholder="Price" value="0"><input type="text" class="form-control lsnoseri-'+ix+'" name="lsnoseri['+ix+']" placeholder="List NoSeri"></td>';
      text=text + '<td><input type="text" class="form-control unit unit-'+ix+'" name="unit['+ix+']" placeholder="Unit"readonly></td>';
      text=text + '<td><input type="text" class="form-control total total-'+ix+'" name="total['+ix+']" placeholder="Total" readonly></td></tr>';
      $('.listItem').append(text);
    });
    $(document).on('click','.process',function () {
      var result=validate();
    });
    function getTotal(params) {
      var a =$('.qty-' + params).val();
      var b =$('.price-' + params).val();
      return (a * b);
    }

    function validate() {
      let valid=false;
      var validates=$('#myform').serialize();
      console.log(validates);
    }
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
@endpush