@extends('layouts/admin')
@section('title','Create New Order')

@section('content_header')

<!-- <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" id="myform">    -->
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
                <label class="col-3">Orders Name</label>
                <div class="col">
                  {{$order[0]->ordername}}
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="col-3">Suppiler Inv.No</label>
                <div class="col">
                {{$order[0]->supno}}
                </div>
              </div>
             
              <div class="form-group mb-3 row">
                <label class="col-3">Date</label>
                <div class="col">
                {{ date('d/m/Y', strtotime($order[0]->orderdate)) }}
                </div>
                
              </div>
              
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="col-3">Vendors</label>
                <div class="col">
                    {{ $Vendor[0]->vendor_name}}
                      
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="col-3">Address</label>
                <div class="col">
                {{$Vendor[0]->address}},{{$Vendor[0]->city}},{{$Vendor[0]->state}},{{$Vendor[0]->country}}
                </div>
              </div>  
              <div class="form-group mb-3 row">
                <label class="col-3">Note</label>
                <div class="col">
                {{$order[0]->note}}
              </div>  
              
            </div>
          </div>
        </div>
        <div class="card">
          <div class="table-responsive"  style="min-height: 150px;">
          <input type="hidden" class="form-control lsnoseri" name="lsnoseri" placeholder="List NoSeri" value="{{$serial}}">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                <tr>
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
                @foreach($details as $detail)
                
                <tr class="ix">
                  <td>
                    {{$detail->Stockcode}}
                  </td>
                  <td>{{ $detail->stockname }}</td>
                  <td>{{ $detail->qty}}<br>
                    @if($detail->qtytype==1)
                    <a href="#" class="seelist " data-ix="{{$detail->StockId}}">see list</a>
                    @endif
                    
                  </td>
                  <td>{{ $detail->hpp}}</td>
                  <td>{{ $detail->unit}}</td>
                  <td style="text-align:right;">{{number_format(($detail->qty * $detail->hpp), 2)}}</td>
                </tr>
                @endforeach
              </tbody>
              
              <tfooter>
              <tr>
                  <td colspan=4>&nbsp;</td>
                  <td >Total</td>
                  <td colspan=1 style="text-align:right;">
                  {{number_format($order[0]->subtotal, 2)}}
                  </td>
                </tr>
                <tr>
                  <td colspan=4>&nbsp;</td>
                  <td >Shipping Cost</td>
                  <td colspan=1 style="text-align:right;">
                  {{number_format($order[0]->shipping, 2)}}
                  </td>
                </tr>
                <tr>
                  <td colspan=4>&nbsp;</td>
                  <td >TAX</td>
                  <td colspan=1 style="text-align:right;">
                  {{number_format($order[0]->tax, 2)}}
                  </td>
                </tr>
                <tr>
                  <td colspan=4>&nbsp;</td>
                  <td >Diskon</td>
                  <td colspan=1 style="text-align:right;">
                  {{number_format($order[0]->discount, 2)}}
                  </td>
                </tr>
                <tr>
                  <td colspan=4>&nbsp;</td>
                  <td >Grand Total</td>
                  <td colspan=1 style="text-align:right;">
                  {{number_format($order[0]->total, 2)}}
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
              <table class="table card-table ">
                <thead>
                  <tr>
                  <th>Stock Code</th><th>Serial Number</th>
                  </tr>
                </thead>
                <tbody class="lsSerial">

                </tbody>
                
              </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary saveserial" >Close</button>
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
    
  
    $('.saveserial').on('click',function () {
      $(".modal-btn").click();
    });
    $('.date').datetimepicker({format: 'DD/MM/YYYY',defaultDate:'now' });
    //$('.stockid').on("change", function () {
   
    $(document).on('click','.seelist',function () {
      console.log('see list');
      var ix=$(this).attr('data-ix');
      var data=JSON.parse($('.lsnoseri').val());
      var list="";
      data.forEach(function(item) {
        if(item.stockid==ix){
          list= list + '<tr><td>'+ item.stockcode +'</td><td>'+ item.serial +'</td></tr>';
        }
      });
      
        
          // var datals=exsist.split(',');
          // for(let i=0;i<arr;i++){
          //   list= list + '<tr><td><input type="text" class="form-control list list-0" name="list['+i+']" placeholder="Serial Number" value="'+ datals[i] +'"></td></tr>';
          // }
        
        $('.lsSerial').empty();
        $('.lsSerial').append(list);
        $('.sindex').empty();
        $('.sindex').val(ix);
        $(".modal-btn").click(); 
        //callModals();
    });
    
    $('#popup').modal({
      backdrop: 'static',
      keyboard: false  // to prevent closing with Esc button (if you want this too)
    });
    
    $(document).on("input propertychange",'.tax', function () {
      summaries();
    });
    $(document).on("input propertychange",'.shipping', function () {
      summaries();
    });
    $(document).on("input propertychange",'.diskon', function () {
      summaries();
    });
    function calculates(params) {
      var a =$('.qty-' + params).val();
      var b =$('.price-' + params).val();
      return (a * b);
    }
    function summaries() {
      let total=0;
      $('.total').each(function(){
        //console.log(this.value);
        total= total + parseInt(this.value);
      });
      $('.totals').val(total);
      //console.log(total);
      var shipping=parseInt($('.shipping').val());
      var tax=parseInt($('.tax').val());
      var diskon=parseInt($('.diskon').val());
      var gtt=total + shipping + tax - diskon;
      $('.gtt').val(gtt);
    }
    

  });
</script>
@endpush