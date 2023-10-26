@extends('layouts/admin')
@section('title','Update Quotes')

@section('content_header')
<form action="{{ route('quotes.update') }}" method="POST" enctype="multipart/form-data">       
    <div class="page-header d-print-none">
      <div class="row align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
          <h1 class="m-0 text-dark">Update Lead </h1>
          </div>
          
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none"> 
          <a href="{{ url('quotes/view',$quotes[0]->id)}}" class="btn btn-light">« Kembali</a>                 
          <button type="submit" class="btn btn-primary">Update</button>
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
            <h3 class="card-title"> Quotes Information</h3>
          </div>
          <div class="card-body row">
          <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Quote Owner</label>
                <div class="col">
                      <select class="form-select" name="ownerid">
                        @foreach($Users as $user)
                          @if($user->id=== $quotes[0]->ownerid)
                            <option selected value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @else
                            <option  value="{{ $user->id }}">{{ $user->first_name}} {{ $user->last_name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Lead</label>
                <div class="col">
                      <select class="form-select" name="leadid">
                        @foreach($Leads as $lead)
                        <?php
                         if(($lead->type=='contact')){$name=$lead->property_name;}else{ $name=$lead->leadsname; }
                      ?>
                          @if($user->id=== $quotes[0]->leadid)
                            <option selected value="{{ $lead->id }}">{{ $name}}</option>
                          @else
                            <option value="{{ $lead->id }}">{{ $name}}</option>
                          @endif
                        @endforeach
                      </select>
                </div>
              </div>    
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Quotes Name</label>
                <div class="col">
                  <input type="text" class="form-control" name="quotename" placeholder="Quote Name" value="{{$quotes[0]->quotename}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Quotes No.</label>
                <div class="col">
                  <input type="text" class="form-control" name="quotenumber" placeholder="Quote Name" value="{{$quotes[0]->quotenumber}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Quote Date</label>
                <div class="col">
                  <div class='input-group date' id='datetimepicker' >
                      <input type='text' name='quotedate' class="form-control"  value="{{date('d/m/Y',strtotime($quotes[0]->quotedate))}}"/>
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">To Contact</label>
                <div class="col">
                  <input type="text" class="form-control" name="toperson" placeholder="To Contact" value="{{$quotes[0]->toperson}}">
                </div>
              </div>
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Address</label>
                <div class="col">
                <textarea class="form-control" name="toaddress" placeholder=""> {{$quotes[0]->toaddress}}</textarea>
                </div>
              </div>  
              
              
              <input type="hidden" name="id" id="id" value="{{$quotes[0]->id}}">
              <input type="hidden" name="updatebyid" value="{{Auth::user()->id}}">
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">File</label>
                <div class="col">
                  <input type="file" class="form-control" name="file" aria-describedby="emailHelp" placeholder="">
                  <br><a href="{{ url($quotes[0]->attcfile)}}" target="_blank" class="btn btn-light">view</a>   
                </div>
              </div>  
              
              <div class="form-group mb-3 row">
                <label class="form-label col-3 col-form-label">Notes</label>
                <div class="col">
                <textarea class="form-control" name="note" placeholder="">{{$quotes[0]->toaddress}}</textarea>
                </div>
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
        <a href="{{ url('quotes/view',$quotes[0]->id)}}" class="btn btn-light">« Kembali</a>                    
        <button type="submit" class="btn btn-primary">Simpan</button>
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
<script type="text/javascript">
  $(function () {
    $('#datetimepicker').datetimepicker({format: 'DD/MM/YYYY'});
   
      
  });
</script>
@endpush