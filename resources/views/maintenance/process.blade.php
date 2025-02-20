@extends('layouts/admin')
@section('title','Process Maintenance')

@section('content_header')
<style>
  .cdetail p span{
    padding: 0 15px 0 10px;
    font-weight: bold;
    width: 100px!important;
    display: inline-block;
  }
</style>

    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark"> Process Maintenance</h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a> 
          <a  class="btn btn-primary process">Simpan</a>
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
            <h3 class="card-title"> Maintenance's Information</h3>
          </div>
          <div class="card-body row">
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Technician</label>
                <div class="col">
                {{$Maintenance[0]->teknisia}} {{$Maintenance[0]->teknisib}}
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Date</label>
                <div class="col">
                {{$Maintenance[0]->date}}
                </div>
                
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Problem</label>
                <div class="col">
                {{$Maintenance[0]->problem}}
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label"></label>
                <div class="col">
                    @if($Maintenance[0]->reqstock ==1 )
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
                {{$Maintenance[0]->customer}}
                </div>
              </div>   
              <div class="form-group mb-3 row cdetail">
                <p><span>Address</span> : {{$Maintenance[0]->address}}</p>
                <p><span>Contact</span> : {{$Maintenance[0]->contact}} ( Mobile : {{$Maintenance[0]->mobile}} )</p>
                <p><span>POPs</span> : {{$Maintenance[0]->pops}}</p>
                <p><span>IP Address</span> : {{$Maintenance[0]->ips}}</p>
              </div>
              
              
             
            </div>
            
          </div>
          <div class="card">
          <div class="table-responsive"  style="min-height: 150px;">
          <input type="hidden" class="form-control id" name="id" value='{{$Maintenance[0]->id}}' readonly>
          <input class="updatedbyid" type="hidden" name="updatedbyid" value="{{Auth::user()->id}}">
          <input type="hidden" class="form-control lsprod" name="lsprod" value='<?php echo json_encode($mstock); ?>' readonly>
          <input type="hidden" class="form-control noseri" name="noseri" value='<?php echo json_encode($StocksNoSeri); ?>' readonly>
          <input type="hidden" class="form-control stockpos" name="stockpos" value='<?php echo json_encode($stockPos); ?>' readonly>
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead> 
                <tr>
                  <th></th>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Qty</th>
                  <th>Unit</th>
                  <th>NoSeri</th>
                  
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody class='listItem'>
               
                <tr>
                <td> <a class="btn btn-danger remove hidden">x</a></td>
                  <td>
                    <select class="form-select stockid stockid-0" name="stockid[0]">
                    <option value="">-- Select One --</option>
                      @foreach($mstock as $stock)
                        <option data-dtl='0|{{ $stock->stockname}}|{{ $stock->qtytype}}|{{ $stock->unit}}|{{ $stock->stockid}}' value="{{ $stock->id }}">{{ $stock->stockid}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td><input class="name-0" type="text" name="ProductName[]" value=""></td>
                  
                  <td class="onqty-0"><input style="width: 75px;" class="qty-0 qty" type="text" name="qty[0]"  data-ix="0" value="0"><input class="qtytype-0" type="hidden" name="qtytype[0]" value="0"></td>
                  <td><input  style="width: 75px;" class="unit-0" type="text" name="unit[0]" value=""readonly></td>
                  <td><div class='mnoseri-0'></div><input class="mserial-0" type="hidden" name="mserial[0]" value="">
                  </td>
                  
                </tr>
              

              </tbody>
              <tfooter>
                <tr class="index">
                  <td>&nbsp;</td>
                  <td>
                  <input type="hidden" class="form-control indexs" name="indexs" value="0" readonly><a href="#" class="addrows  btn btn-primary">add New Rows</a>
                  </td>
                </tr>
              </tfooter>
              
              
            </table>
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
      <a  class="btn btn-primary process">Simpan</a>
      </div>
    </div>
  </div>
</div>
<!-- </form> -->
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

<link href="{{asset('public/libs/jqueryui/jquery-ui.css')}}" rel="stylesheet" />
<script src="{{asset('public/libs/jqueryui/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
  $(function () {

    var lisNoseries=JSON.parse($('.noseri').val());

    $(document).on("change",'.stockid', function () {
      var option = $('option:selected', this).attr('data-dtl');
      var options=option.split("|");
      // console.log(options[0]);
      
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
                // console.log(value.noseri);  
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
      $('.seelist-'+option).remove();
          $('.onqty-'+option).append('<a href="#" class="seelist seelist-'+option+'" data-ix="'+option+'">see list</a>');
      // console.log(duplicateElements);
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

    $('.addrows').on('click', function() {
      let ix = parseInt($('.indexs').val()) + 1;
      $('.indexs').val(ix);
      var options='';
      var text ='<tr class="ix-'+ix+'"><td> <a class="btn btn-danger remove hidden">x</a></td><td> <select class="form-select stockid stockid-'+ix+'" name="stockid['+ix+']"><option>-- select one --</option>';
      var series=JSON.parse($('.lsprod').val());
      $(series).each(function(index, value){ //loop through your elements
        options += '<option data-dtl="'+ix+'|'+value.stockname+'|'+value.qtytype+'|'+value.unit+'|'+value.stockid+'" value="'+ value.id +'">'+value.stockname+'</option>'; //add the option element as a string    
      });                        
      text=text + options;                      
      text=text + '</select><input type="hidden" class="form-control stockcode-'+ix+'" name="stockcode['+ix+']" ></td>';
      text=text + '<td><input type="text" class="name-'+ix+'" name="name['+ix+']" ></td>';
      text=text + '<td class="onqty-'+ix+'"><input type="text"  style="width: 75px;"  class=" qty qty-'+ix+'" name="qty['+ix+']" data-ix="'+ix+'" placeholder="Qty" value="0"><input type="hidden" class="form-control qtytype-'+ix+'" name="qtytype['+ix+']" ><input type="hidden" class="form-control lsnoseri-'+ix+'" name="lsnoseri['+ix+']" placeholder="List NoSeri"></td>';
      text=text + '<td><input type="text" class="unit unit-'+ix+'" name="unit['+ix+']" placeholder="Unit"readonly></td>';
      text=text + '<td><div class="mnoseri-'+ix+'"></div><input type="hidden" class="mserial-'+ix+'" name="mserial['+ix+']" ></td>';
      $('.listItem').append(text);
    });

    $(document).on('click','.process',function (e) {
      var result=validate();
      if(result==true){
        var arr=$('.indexs').val();
        let listItem=[];
        let valids=true;
        for(let i=0; i<=arr;i++){
          if($('.qtytype-'+i).val()==1){
            var cekit=($('.mserial-'+i).val()).split(',');
            
            cekit.forEach(element => {
              if(element === undefined || element === null || element === ''){
                valids=false;
              }
              
            });
            if(valids==false){
              alert('In Complete Serial Number');
            }
          }
          var items={
            'stockid' : $('.stockid-'+i+' option:selected').val(),
            'qty' : $('.qty-'+i).val(),
            'qtytype' : $('.qtytype-'+i).val(),
            'mserial' : $('.mserial-'+i).val()
          };
          listItem.push(items);
        }

        if(valids==true){
          var data={
            'id':$('.id').val(),
            'updatedbyid':$('.updatedbyid').val(),
            'row' : $('.indexs').val(),
            'Item_List' : listItem
          };
          console.log(data);
          
          $.ajaxSetup({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
          });
          //$('.process').attr("disabled", true);

          $.ajax({
            url: "{{route('maintenance.reprocess')}}",
            type: "POST",
            data: data,
            success: function( response ) {
              
              //$('.process').removeAttr('disabled');
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
   
    function validate() {
      let valid=true;
      var arr=$('.indexs').val();
      for(let i=0; i<=arr;i++){
        var qtytype=$('.qtytype-'+i).val();
        if(qtytype==1){//if serial
          var qty=parseInt($('.qty-'+i).val());
          var serial=$('.mserial-'+i).val();
          var serials=serial.match(/[^,]+/g);
          if(qty!=serials.length){ 
            alert("some serial is difrent");
            valid=false;
          }
        }
        
      }

      //console.log(decodeURIComponent(validates));
      return valid;
      
    }

    $(document).on('click','.seelist',function () {
      var ix=$(this).attr('data-ix');
      var arr=$('.qty-'+ix).val();
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
            // console.log(value.noseri);  
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

  });
</script>

<style>
  ul.ui-autocomplete {
    z-index: 1100;
  }
</style>

@endpush