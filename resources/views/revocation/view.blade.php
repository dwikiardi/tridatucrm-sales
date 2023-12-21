@extends('layouts/admin')
@section('title','Detail Revocation')

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
          <h1 class="m-0 text-dark"> Revocation </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          
          <a href="{{ url('revocation')}}" class="btn btn-light">« Kembali</a> 
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
                <label class="form-label col-3 col-form-label">Technision</label>
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

          <div class="card-body row">
          <div class="form-group">
            Installed On Customer 
          </div>  
          <table class="table card-table table-vcenter text-nowrap datatable">
            <thead> 
              <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>NoSeri</th>
                
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody class='listItem'>
              @foreach($installed as $item)
              <tr>
                <td>{{$item->stockcodename}}</td>
                <td>{{$item->stockname}}</td>
                <td>{{$item->qty}} {{$item->unit}}</td>
                <td>{{$item->noseri}}</td>
                
                <!-- <th>Action</th> -->
              </tr>
              @endforeach
            </tbody>
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
      </div>
    </div>
  </div>
</div>
<!-- </form> -->

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
    

  });
</script>
@endpush