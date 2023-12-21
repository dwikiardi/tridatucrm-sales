@extends('layouts/admin')
@section('title','Product Details')
@section('add_css')
<style>
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{
  color: #fff;
  background-color: #206bc4;
}
  .dataTables_filter{
    float: right;
    padding-right:15px;
  }
  .dataTables_length{
    padding-left:15px;
  }
  .dataTables_length label{
    display: inline-flex;
    padding: 5px;
  }
  .dataTables_length label select{
    margin: 0 5px;
  }
  .dataTables_info{
    padding: 5px 15px;
  }
</style>
@stop
@section('content_header')
    
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            <ul class="nav nav-tabs" data-bs-toggle="tabs" style=" margin-bottom: 15px; border-bottom: none;">
              <li class="nav-item" style="margin-right: 15px;">
                <a href="#tabs-home-17" class="nav-link active" data-bs-toggle="tab" style="border: solid #cbd5e1 1px!important;border-radius: 15px;">Overview</a>
              </li>
              <li class="nav-item">
                <a href="#tabs-profile-17" class="nav-link" data-bs-toggle="tab" style="border: solid #cbd5e1 1px!important;border-radius: 15px;">Timeline</a>
              </li>
              <li class="nav-item">
                <a href="#tabs-profile-18" class="nav-link" data-bs-toggle="tab" style="border: solid #cbd5e1 1px!important;border-radius: 15px;">Stock History</a>
              </li>
            </ul>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('product')}}" class="btn btn-light">« Kembali</a>
          <a href="{{ url('product/edit',$stocks[0]->id)}}" class="btn btn-primary d-none d-sm-inline-block" >
            Update Product
          </a>
        </div>
      </div>
    </div>
@stop
@section('content')
<div class="container-xl">
  <div class="row row-cards">
    <div class="col-12">
      <div class="tab-content">
        <div class="tab-pane fade active show" id="tabs-home-17">
          <div class="container-xl" style="padding: 0!important;">
            <div class="row row-cards" data-masonry='{"percentPosition": true }'>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-blue-lt">
                    <h3 class="card-title"> Product Information</h3>
                  </div>
                  <div class="card-body row">
                    <div class="col-12">
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Product Code</label>
                        <div class="col">
                          {{$stocks[0]->stockid}}
                        </div>
                      </div>
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Product Name</label>
                        <div class="col">
                          {{$stocks[0]->stockname}}
                        </div>
                      </div>
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Description</label>
                        <div class="col">
                        {{$stocks[0]->desk}}
                        </div>
                      </div>  
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Category</label>
                        <div class="col">
                          {{$stocks[0]->category_name}}
                        </div>
                      </div>    
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Unit Type </label>
                        <div class="col">
                          {{$stocks[0]->unit}}
                        </div>
                      </div>
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Qty Type</label>
                        <div class="col">
                          @if($stocks[0]->qtytype == 0)
                            Qty
                          @else
                          By Summary of Serial Number
                          @endif
                        </div>
                      </div>    
                      <div class="form-group mb-3 row">
                        <label class="form-label col-3 col-form-label">Sell Price</label>
                        <div class="col">
                          {{$stocks[0]->sell_price}}
                        </div>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-blue-lt">
                    <h3 class="card-title"> Stocks Information</h3>
                  </div>
                  <div class="card-body row">
                    <div class="col-12">
                    <div class="table-responsive"  style="min-height: 275px;">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>Product Code</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th></th>
                          <th>Qty</th>
                        </tr>
                      </thead>
                      <tbody></tbody>
                    </table>
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
                  <a href="{{ url('product')}}" class="btn btn-light">« Kembali</a>  
                  <a href="{{ url('product/edit',$stocks[0]->id)}}" class="btn btn-primary d-none d-sm-inline-block" >
                    Update Product
                  </a> 
                </div>
              </div>
            </div>
          </div>
 
        </div>
        <div class="tab-pane fade" id="tabs-profile-17">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-blue-lt">
              <h3 class="card-title"> History </h3>
            </div>
            <div class="card-body row">
              <ul class="list list-timeline">
                @foreach($logs as $log)
                <li>
                  <div class="list-timeline-icon"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                    <!-- SVG icon code -->
                    @if (strpos($log->logname, 'Create') !== FALSE)
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                        <path d="M9 12l6 0"></path>
                        <path d="M12 9l0 6"></path>
                      </svg>
                    @endif
                    @if (strpos($log->logname, 'Update') !== FALSE)
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                        <path d="M13.5 6.5l4 4"></path>
                      </svg>
                    @endif
                    
                    
                  </div>
                  <div class="list-timeline-content">
                    <div class="list-timeline-time">{{ $log->created_at }}</div>
                    <p class="list-timeline-title">{{$log->subject}}</p>
                    <p class="text-muted">{{ $log->firstname }} {{ $log->lastname }}</p>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        </div>
        <div class="tab-pane fade" id="tabs-profile-18">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-blue-lt">
              <h3 class="card-title"> History </h3>
            </div>
            <div class="card-body row">
              <ul class="list list-timeline">
                @foreach($stocklog as $log)
                <li>
                  <div class="list-timeline-icon"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                    <!-- SVG icon code -->
                    @if ($log->transtype == 1) <!-- purchase -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                      <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                      <path d="M17 17h-11v-14h-2" />
                      <path d="M6 5l14 1l-1 7h-13" />
                    </svg>
                    <!-- <p>Purchase</p> -->
                    @endif
                    @if ($log->transtype == 3)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                    <!-- <p>To Staff</p> -->
                    @endif
                    @if ($log->transtype == 4)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2c.641 0 1.212 .302 1.578 .771" /><path d="M20.136 11.136l-8.136 -8.136l-9 9h2v7a2 2 0 0 0 2 2h6.344" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                    <!-- <p>Installation</p> -->
                    @endif
                    @if ($log->transtype == 5)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2c.247 0 .484 .045 .702 .127" /><path d="M19 12h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h5" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                    <!-- <p>Revocation</p> -->
                    @endif
                   
                    @if ($log->transtype == 6)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12.5 17h-6.5v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                    <!-- <p>Purchase Return</p> -->
                    @endif
                    @if ($log->transtype == 7)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17a2 2 0 1 0 2 2" /><path d="M17 17h-11v-11" /><path d="M9.239 5.231l10.761 .769l-1 7h-2m-4 0h-7" /><path d="M3 3l18 18" /></svg>
                    <!-- <p>Broken</p> -->
                    @endif
                    @if ($log->transtype == 8)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2c.247 0 .484 .045 .702 .127" /><path d="M19 12h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h5" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                    <!-- <p>Cancel Instalation</p> -->
                    @endif
                    @if ($log->transtype == 9)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-traffic-cone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20l16 0" /><path d="M9.4 10l5.2 0" /><path d="M7.8 15l8.4 0" /><path d="M6 20l5 -15h2l5 15" /></svg>
                    <!-- <p>Maintenance</p> -->
                    @endif
                    @if ($log->transtype == 10)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 21v-6a2 2 0 0 1 2 -2h2c.247 0 .484 .045 .702 .127" /><path d="M19 12h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h5" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                    <!-- <p>Cancel Maintenance</p> -->
                    @endif
                    @if ($log->transtype == 11)<!-- transferOut to staff -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart-share" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 19a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M12.5 17h-6.5v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /><path d="M16 22l5 -5" /><path d="M21 21.5v-4.5h-4.5" /></svg>
                    <!-- <p>Purchase Return</p> -->
                    @endif
                    
                    
                  </div>
                  <div class="list-timeline-content">
                    <div class="list-timeline-time">{{ $log->created_at }}</div>
                    <p class="list-timeline-title">{{$log->subject}}</p>
                    @if ($log->transtype == 1) <!-- purchase -->
                    <p>Purchase</p>
                    @endif
                    @if ($log->transtype == 3)<!-- transferOut to staff -->
                    <p>To Staff</p>
                    @endif
                    @if ($log->transtype == 4)<!-- transferOut to staff -->
                    <p>Installation</p>
                    @endif
                    @if ($log->transtype == 5)<!-- transferOut to staff -->
                    <p>Revocation</p>
                    @endif
                    @if ($log->transtype == 6)<!-- transferOut to staff -->
                    <p>Purchase Return</p>
                    @endif
                    @if ($log->transtype == 7)<!-- transferOut to staff -->
                    <p>Broken</p>
                    @endif
                    @if ($log->transtype == 8)<!-- transferOut to staff -->
                    <p>Cancel Instalation</p>
                    @endif
                    @if ($log->transtype == 9)<!-- transferOut to staff -->
                    <p>Maintenance</p>
                    @endif
                    @if ($log->transtype == 10)<!-- transferOut to staff -->
                    <p>Cancel Maintenance</p>
                    @endif
                    <p class="text-muted"><b>Transaction : {{$log->transcation_number}}</b> <br>
                    @if ($log->qtytype == 1)
                    serial Number: {{$log->serial}}
                    @else
                    Qty: {{$log->qty}} {{$log->unit}}
                    @endif
                    <br>By : {{ $log->firstname }} {{ $log->lastname }}</p>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        </div>
      </div>
        
    </div>
  </div>
</div>
@stop
@push('js')
@push('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
      
    var table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.getstock',$stocks[0]->id) }}",
        columns: [
          {data: 'stockid', name:'stockid'},
          {data: 'stockname', name:'stockname'},
          {data: 'modules', name:'modules'},
          {data: 'NAME', name:'NAME'},
          {data: 'qty', name:'qty'}
        ]
    });
  });
</script>
@endpush
@endpush