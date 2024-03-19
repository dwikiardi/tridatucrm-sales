@extends('layouts/admin')
@section('title','Detail Maintenance')

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
          <h1 class="m-0 text-dark"> Maintenance </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('maintenance/edit')}}/{{ $Maintenance[0]->id}}" class="btn btn-primary  d-sm-inline-block">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            Edit Maintenance
          </a>
          <a href="{{ url('maintenance')}}" class="btn btn-light">« Kembali</a> 
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